<?php
require_once __DIR__."/../database_class/database.php";
require_once __DIR__.'/../classes/class_gen_name.php';
require_once __DIR__ ."/../lib/toolkit-image/AcImage.php";
require_once __DIR__ ."/../lib/toolkit-image/AcImageGIF.php";
require_once __DIR__ ."/../lib/toolkit-image/AcImageJPG.php";
require_once __DIR__ ."/../lib/toolkit-image/AcImagePNG.php";


$target=$_POST['target'];
$back=array();
//echo "<pre>"; print_r($_FILES); "</pre>";
//echo "<pre>"; print_r($_POST); "</pre>";die;

//delete image in gallery in list_gal_images.php
if($target=='delete_image_in_gallery'){
    if(!empty($_POST)){
        $image=$_POST['image'];
        $image_id=$_POST['image_id'];
        $album_id=$_POST['album_id'];
        if(!empty($image)){
            unlink("../uploads/gallery_images/$image");
        }
        $db->where('id',$image_id);
        $delete=$db->delete('album_gallery');
        if($delete){
            $db->where('album_id',$album_id);
            $db->orderBy('list_order','asc');
            $gal_img=$db->get('album_gallery');
            $count=1;
             foreach($gal_img as $img){
                 $img_id=$img['id'];
                 $data=array(
                     'list_order'=>$count
                 );
                 $db->where('id',$img_id);
                 $update=$db->update('album_gallery',$data);
                 $count++;
             }
            $db->where('album_id',$album_id);
            $count_images=$db->getValue('album_gallery',"count(*)");
            $back['error']=0;
            $back['album_id']=$album_id;
            $back['count_images']=$count_images;
        }
    }
}
//edit image_desc in gallery in list_gal_images.php
if($target=='edit_image_desc_in gallery'){
//    echo 'hello';
    if(!empty($_POST)){
        $image_desc=$_POST['image_desc'];
        $image_id=$_POST['image_id'];
        $album_id=$_POST['album_id'];
        $data=array(
            'image_desc'=>$image_desc
        );
        $db->where('id',$image_id);
        $update=$db->update('album_gallery',$data);
        if($update){
            $back['error']=0;
            $back['album_id']=$album_id;
        }
    }


}
//sort image in gallery
if($target=='edit_listOrder_gallery_image'){
    $listOrder=$_POST['OrderImg'];
    $listOrder=array_reverse($listOrder);
    $count=1;

    foreach($listOrder as $order){
        $data=array(
            'list_order'=>$count
        );
        $db->where('id',$order);
        $update=$db->update('album_gallery',$data);
        $count++;
    }
}
//add image in gallery
if($target=='add_image_in_gallery'){
    $album_id=$_POST['album_id'];
    $image_desc=$_POST['image_desc'];
    $image=$_FILES['image'];
    if($image['error']==0){
        $path=__DIR__."/../uploads/gallery_images";
        $extension = strtolower(substr(strrchr($image['name'], '.'), 1));
        $filename = DFileHelper::getRandomFileName($path, $extension);
        $image_name=$filename .'.'. $extension;
        $target = $path . '/' . $filename . '.' . $extension;
        $tmp_name = $image["tmp_name"];
        $save_main=move_uploaded_file($tmp_name, $target);
        if($save_main) {
            $img = AcImage::createImage(__DIR__."/../uploads/gallery_images/$image_name");
            $img->resizeByWidth(800);
            AcImage::setQuality(100);
            AcImage::setRewrite(true);
            $img_load=$img->save(__DIR__."/../uploads/gallery_images/$image_name");
            if($img_load){
                $db->where('album_id',$album_id);
                $count = $db->getValue ("album_gallery", "count(*)");
                $order=$count+1;
                $data=array(
                    'image_gallery'=>$image_name,
                    'image_desc'=>$image_desc,
                    'list_order'=>$order,
                    'album_id'=>$album_id
                );
                $id=$db->insert('album_gallery',$data);
                if($id){
                    $back['album_id']=$album_id;
                    $back['image']=$image_name;
                    $back['image_id']=$id;
                    $back['image_desc']=$image_desc;
                    $back['count_images']=$order;
                }
            }
        }
    }
}
if($target=='edit_album'){
    $album_id=$_POST['album_id'];
    $album_name=$_POST['album_name'];
    $album_description=$_POST['album_desc'];
    $album_description1=nl2br(htmlspecialchars(addslashes(trim($album_description))));
    $old_main_image=$_POST['old_main_image'];
    $new_main_img=$_FILES['new_main_img'];
        if($new_main_img['error']==0){
            if(!empty($album_name)){
                unlink(__DIR__."/../uploads/main_image/$old_main_image");
                unlink(__DIR__."/../uploads/gallery_images/$old_main_image");
            }
            $path=__DIR__."/../uploads/main_image";
            $path1=__DIR__."/../uploads/gallery_images";
            $extension = strtolower(substr(strrchr($new_main_img['name'], '.'), 1));
            $filename = DFileHelper::getRandomFileName($path, $extension);
            $image_name=$filename .'.'. $extension;
            $target = $path . '/' . $filename . '.' . $extension;
            $tmp_name = $new_main_img["tmp_name"];
            $save_main=move_uploaded_file($tmp_name, $target);
            $save_gal=copy($target,$path1.'/'.$image_name);
            if($save_main) {
                $img = AcImage::createImage(__DIR__."/../uploads/gallery_images/$image_name");
                $img->resizeByWidth(800);
                AcImage::setQuality(100);
                AcImage::setRewrite(true);
                $img_load1=$img->save(__DIR__."/../uploads/gallery_images/$image_name");
            }
            if($save_gal){
                $img = AcImage::createImage(__DIR__."/../uploads/main_image/$image_name");
                $img->resizeByWidth(150);
                AcImage::setQuality(100);
                AcImage::setRewrite(true);
                $img_load2=$img->save(__DIR__."/../uploads/main_image/$image_name");
            }
                if($save_main && $save_gal){
                    $data=array(
                        'album_name'=>$album_name,
                        'album_description'=> $album_description1,
                        'album_image'=>$image_name
                    );
                    $db->where('id',$album_id);
                    $update=$db->update('albums',$data);
                    if($update){
                        $back['album_id']=$album_id;
                        $back['album_name']=$album_name;
                        $back['album_description']=$album_description1;
                        $back['album_image']=$image_name;
                    }
                }
        }else{
            $data=array(
                        'album_name'=>$album_name,
                        'album_description'=>$album_description1,
                        );
            $db->where('id',$album_id);
            $update=$db->update('albums',$data);
            if($update){
                $back['album_id']=$album_id;
                $back['album_name']=$album_name;
                $back['album_description']=$album_description1;
                $back['album_image']=$old_main_image;
            }
        }
}
if($target=='delete_album'){
    if(!empty($_POST)){
        $album_image=$_POST['album_image'];
        $album_id=$_POST['album_id'];
        if(!empty($album_image) && !empty($album_id)){
            unlink(__DIR__."/../uploads/main_image/$album_image");
            unlink(__DIR__."/../uploads/gallery_images/$album_image");
        }
        $db->where('id',$album_id);
        $del=$db->delete('albums');
        if($del){
            $db->orderBy("list_order","asc");
            $all_albums=$db->get('albums');
            $count=1;
            foreach($all_albums as $album){
                $alb_id=$album['id'];
                $data=array(
                    'list_order'=>$count
                );
                $db->where('id',$alb_id);
                $update=$db->update('albums',$data);
                $count++;
            }
            $db->where('album_id',$album_id);
            $gal_data=$db->get('album_gallery');
            if($gal_data){
                foreach($gal_data as $gal_image){
                    $image=$gal_image['image_gallery'];
                    unlink(__DIR__."/../uploads/gallery_images/$image");
                }
                $db->where('album_id',$album_id);
                $del_images=$db->delete('album_gallery');
                if($del_images){
                    $back['album_id']=$album_id;
                }
            }else{
                $back['album_id']=$album_id;
            }
        }
    }
}
//edit order albums in sort_albums.php
if($target=='edit_listOrder'){
    $listOrder=$_POST['listOrder'];
    $listOrder=array_reverse($listOrder);
    $count=1;

    foreach($listOrder as $order){
        $data=array(
                'list_order'=>$count
        );
        $db->where('id',$order);
        $update=$db->update('albums',$data);
        $count++;
    }
}
if($target=="add_new_album"){
    if(!empty($_POST && !empty($_FILES))){
        $album_name=$_POST['album_name'];
        $creat_date=$_POST['creat_date'];
        $album_creat_date=$_POST['album_creat_date'];
        $album_description=$_POST['album_desc'];
        $album_description1=nl2br(htmlspecialchars(addslashes(trim($album_description))));
        $image=$_FILES['album_file'];
    }
    if($image['error']==0){
        $path=__DIR__."/../uploads/main_image";
        $path1=__DIR__."/../uploads/gallery_images";
        $extension = strtolower(substr(strrchr($image['name'], '.'), 1));
        $filename = DFileHelper::getRandomFileName($path, $extension);
        $image_name=$filename .'.'. $extension;
        $target = $path . '/' . $filename . '.' . $extension;
        $tmp_name = $image["tmp_name"];
        $data1=move_uploaded_file($tmp_name, $target);
        $data2=copy($target,$path1.'/'.$image_name);
        if($data1) {
            $img = AcImage::createImage(__DIR__."/../uploads/gallery_images/$image_name");
            $img->resizeByWidth(800);
            AcImage::setQuality(100);
            AcImage::setRewrite(true);
            $img_load1=$img->save(__DIR__."/../uploads/gallery_images/$image_name");
        }
        if($data2){
            $img = AcImage::createImage(__DIR__."/../uploads/main_image/$image_name");
            $img->resizeByWidth(150);
            AcImage::setQuality(100);
            AcImage::setRewrite(true);
            $img_load2=$img->save(__DIR__."/../uploads/main_image/$image_name");
        }
        if($data1 && $data2){
            $count = $db->getValue ("albums", "count(*)");
            $count= $count+1;

            $data=array(
                'album_name'=>$album_name,
                'album_description'=> $album_description1,
                'album_image'=>$image_name,
                'creat_date'=>$creat_date,
                'list_order'=>$count,
                'album_creat_date'=>$album_creat_date
            );
            $id=$db->insert('albums',$data);
            if($id){
                $db->where('album_id',$id);
                $count = $db->getValue ("album_gallery", "count(*)");
                $count= $count+1;
                $gal_data=array(
                    'image_gallery'=>$image_name,
                    'image_desc'=>'',
                    'album_id'=>$id,
                    'list_order'=>$count
                );
                $save=$db->insert('album_gallery',$gal_data);
                if($save){
                    $back['album_name']=$album_name;
                    $back['album_description']=$album_description;
                    $back['album_image']=$image_name;
                    $back['creat_date']=$creat_date;
                    $back['album_id']=$id;
                }
            }

        }
    }else{
        echo "Error Load Image :".$image['error'];
    }
}
echo json_encode($back);
?>