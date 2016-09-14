<?php
    require __DIR__."/database_class/db_bez_ses.php";
    $nowTime=time();


//    here we have the total row count
    $rows = $db->getValue ("albums", "count(*)");
//    this is the number of results we want displayed per page
    $page_rows=12;
//    this tells us the page number of our last page
    $last=ceil($rows/$page_rows);
//    this makes sure last cannot be less than 1
    if($last<1){
        $last=1;
    }
//    establish the $pagenum varriable
    $pagenum=1;
//    get pagenum from url vars if it is present,else it is =1
    if(isset($_GET['pn'])){
        $pagenum=preg_replace('#[^0-9]#','',$_GET['pn']);
    }
//    this makes sure the page number isn't below 1, or more than out $last page
    if($pagenum<1){
        $pagenum=1;
    }else if($pagenum>$last){
        $pagenum=$last;
    }
//    this sets the range of rows to query for the chosen $pagenum
    $limit=($pagenum-1)*$page_rows;
//    this is query again,in is for grabbing just one page worth of rows by applying $limit
    $db->orderBy("list_order","desc");
    $data=$db->get('albums',Array($limit,$page_rows));
//    this show the user what page they are on,and the total number of pages
    $textline1="testimonials(<b>$rows</b>)";
    $textline2="Страница <b>$pagenum</b> of <b>$last</b>";
//    establish the $paginationCtrls varriable
    $paginationCtrls='';
//    if there is more than 1 page worthof results
    if($last!=1){
            if($pagenum>1){
                $previous=$pagenum-1;
                $paginationCtrls .='<a href="#" onclick="javascript:pagination('.$previous.')">Previous</a> &nbsp; &nbsp;';
                for($i=$pagenum-4;$i<$pagenum;$i++){
                    if($i>0){
                        $paginationCtrls.='<a href="#" onclick="javascript:pagination('.$i.')">'.$i.'</a> &nbsp;';
                    }
                }
            }
            //  render the target page number,but without it being a link
            $paginationCtrls.=''.$pagenum.'&nbsp;';
            for($i=$pagenum+1;$i<=$last;$i++){
                $paginationCtrls .= '<a href="#" onclick="javascript:pagination('.$i.')">'.$i.'</a> &nbsp;';
                if($i>=$pagenum+4){
                    break;
                }
            }
//        this does the same as above ,only checking  if we are on the last page,and then generating the 'next'
        if($pagenum!=$last){
            $next=$pagenum+1;
            $paginationCtrls.='&nbsp; &nbsp; <a href="#" onclick="javascript:pagination('.$next.')">Next</a>';
        }
    }

foreach($data as $key=>$row):
    $description=$row['album_description'];
    $desc= htmlspecialchars_decode($description);
    $description=strip_tags($desc,'<br/>');
?>
    <div class="col-sm-2 <?php echo $key;?>" id="album_<?php echo $row['id'];?>">
        <div class="panel panel-primary">
            <a href="view_album.php?album_id=<?php echo $row['id'];?>">
				<div class="panel-body body" >
					<img src="uploads/main_image/<?php echo $row['album_image'];?>" class="img-responsive main_image"  alt="Image">
				</div>
				<div class="panel-footer" style="max-height: 10;">
					<?php echo $row['album_name'];?>
				</div>
			</a>
        </div>
    </div>
<?php
endforeach;

?>
<div class="container pagination">
    <div class="row">
        <div id="pagination_controls"><?php echo $paginationCtrls;?></div>
    </div>

</div>