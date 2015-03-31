<!-- Форма для закачки файл используется в качестве целевого для виджета загрузки файлов -->
<div class="row fileupload-buttonbar">
	<div class="span7">
		<!-- The fileinput-button span is used to style the file input field as button -->
		<span class="btn btn-success fileinput-button">
            <span class="lbl-txt">Загрузить</span>
			<?php
            if ($this -> hasModel()) :
                echo CHtml::activeFileField($this->model, $this->attribute, $htmlOptions) . "\n";
            else :
                echo CHtml::fileField($name, $this-> alue, $htmlOptions) . "\n";
           endif;
            ?>
		</span>
	</div>
</div>
<!-- The loading indicator is shown during image processing -->
<div class="fileupload-loading"></div>
<div class="table table-striped">
    <ul class="files" id="ulfiles" data-toggle="modal-gallery" data-target="#modal-gallery">

    </ul>
</div>

