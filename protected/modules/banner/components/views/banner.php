<a href="<?php echo $model->url;?>" title="<?php echo $model->name;?>" target="_blank" id="target-banner">
    <?php if($model->img):?>
    <img src="/content/banners/<?php echo $model->img;?>" alt="<?php echo $model->name;?>" width="<?php echo $model->width;?>" height="<?php echo $model->height;?>" border="0" />
    <?php elseif($model->html):?>
    <?php echo $model->html;?>
    <?php endif;?>
</a>
<script>
   $(document).ready(function(){
       $('#target-banner').click(function(event){
           //event.preventDefault();
           $.ajax({
                   url:'/banner/banners/setClick',
                   type: "POST",
                   data: ({id : "<?php echo $model->id?>"})
               }
           );
       });
   });
</script>