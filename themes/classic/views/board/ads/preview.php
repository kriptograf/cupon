<div class="wrapper layout">
    <div class="wrapper-inner">

        <?php $this->widget('MainMenuWidget');?>
        <!-- ### end main menu -->

        <div class="equal">
            <div class="main">

                <div id="form-title" class="title-section">
                    <h1 class="section-h1">Товары и ...</h1>

                    <span class="add-board">
                        <a href="/board/ads/create">Добавить объявление</a>
                    </span>
                    <span class="count-board">Объявлений / <?php echo $dataProvider->totalItemCount;?></span>
                </div>

                <!-- filter-->
                <?php $this->widget('FilterWidget');?>

                <div class="spacer-view">
                    <a id="back" href="#">К списку</a>

                    <a id="complain" href="#">Пожаловаться</a>
                    <a id="print" href="#">Распечатать /</a>
                </div>

                <div id="left">
                    <div id="title">
                        <strong>
                            <script>
                                document.write(window.opener.document.getElementById('Ads_title').value);
                            </script>
                        </strong><br>
                        <span>
                            <script>
                                if(window.opener.document.getElementById('Ads_price').value)
                                {
                                    document.write(window.opener.document.getElementById('Ads_price').value+' руб.');
                                }
                                else
                                {
                                    document.write('Цена не указана');
                                }
                            </script>
                        </span>
                    </div>
                    <div id="contacts">
                        <h3>Контакты продавца</h3>
                    </div>
                    <div id="name">
                        <script>
                            document.write(window.opener.document.getElementById('Ads_author').value);
                        </script>
                    </div>
                    <div id="phone">
                        <script>
                            document.write(window.opener.document.getElementById('Ads_phone').value);
                        </script>
                    </div>
                    <div id="email">
                        <script>
                            document.write(window.opener.document.getElementById('Ads_email').value);
                        </script>
                    </div>
                    <div id="date-pub">Дата подачи: <?php echo date('d.m.Y',time());?></div>
                    <div id="map">карта</div>
                </div>

                <div id="right">
                    <div id="thumbs">

                        <ul>
                            <script>
                                var images = [];
                                $(window.opener.document).find('.btn-danger').each(function(i){
                                    var inner = this.innerHTML;
                                    images[i]=$(inner).attr('src');
                                    document.write('<li style="margin-right: 5px;">');
                                    document.write('<a href="#">');
                                    document.write(inner);
                                    document.write('</a>');
                                    document.write('</li>');
                                });
                            </script>
                        </ul>
                    </div>
                    <div id="big">
                        <script>document.write('<img src="'+images[0].replace("/thumbs","")+'">');</script>
                    </div>
                    <div id="details">
                        <p id="detail-title">
                            <script>
                                document.write(window.opener.document.getElementById('Ads_title').value);
                            </script>
                        </p>
                        <p id="detail-text">
                            <script>
                                document.write(window.opener.document.getElementById('Ads_details').value);
                            </script>
                        </p>
                        <p id="views">Просмотров: 0</p>
                    </div>
                </div>

            </div>  <!-- ### end main section -->

            <div class="sidebar">
                <?php $this->widget('SectionsWidget');?>
            </div>  <!-- ### end sidebar section -->
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        //Смена изображения при клике
        $("#thumbs ul li a").click(function(event) {
            event.preventDefault();
            var mainImage = $(this).attr("href"); //Find Image Name
            $("#big img").attr({ src: mainImage });
            return false;
        });
    });
</script>

