<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <li class="template-download fade">
            {% if (file.error) { %}
                <span>{%=file.name%}</span>
                <span>{%=o.formatFileSize(file.size)%}</span>
                <span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}
            {% } else { %}

                <div class="preview">
                    {% if (file.thumbnail_url) { %}
                    <span class="delete">
                        <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}" title="Удалить">
                            <img src="{%=file.thumbnail_url%}">
                        </button>
                    </span>

                    {% } %}
                </div>

            {% } %}
        </li>
{% } %}
</script>
