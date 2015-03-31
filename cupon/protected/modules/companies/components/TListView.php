<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 26.04.13
 * Time: 14:58
 * To change this template use File | Settings | File Templates.
 */
Yii::import('zii.widgets.CListView');
class TListView extends CListView
{
    public $itemView;
    /**
     * @var string the HTML code to be displayed between any two consecutive items.
     * @since 1.1.7
     */
    public $separator;
    /**
     * @var array additional data to be passed to {@link itemView} when rendering each data item.
     * This array will be extracted into local PHP variables that can be accessed in the {@link itemView}.
     */
    public $viewData=array();
    /**
     * @var array list of sortable attribute names. In order for an attribute to be sortable, it must also
     * appear as a sortable attribute in the {@link IDataProvider::sort} property of {@link dataProvider}.
     * @see enableSorting
     */
    public $sortableAttributes;
    /**
     * @var string the template to be used to control the layout of various components in the list view.
     * These tokens are recognized: {summary}, {sorter}, {items} and {pager}. They will be replaced with the
     * summary text, the sort links, the data item list, and the pager.
     */
    public $template="{summary}\n{sorter}\n{items}\n{pager}";
    /**
     * @var string the CSS class name that will be assigned to the widget container element
     * when the widget is updating its content via AJAX. Defaults to 'list-view-loading'.
     * @since 1.1.1
     */
    public $loadingCssClass='list-view-loading';
    /**
     * @var string the CSS class name for the sorter container. Defaults to 'sorter'.
     */
    public $sorterCssClass='sorter';
    /**
     * @var string the text shown before sort links. Defaults to 'Sort by: '.
     */
    public $sorterHeader;
    /**
     * @var string the text shown after sort links. Defaults to empty.
     */
    public $sorterFooter='';
    /**
     * @var mixed the ID of the container whose content may be updated with an AJAX response.
     * Defaults to null, meaning the container for this list view instance.
     * If it is set false, it means sorting and pagination will be performed in normal page requests
     * instead of AJAX requests. If the sorting and pagination should trigger the update of multiple
     * containers' content in AJAX fashion, these container IDs may be listed here (separated with comma).
     */
    public $ajaxUpdate;
    /**
     * @var string the jQuery selector of the HTML elements that may trigger AJAX updates when they are clicked.
     * If not set, the pagination links and the sorting links will trigger AJAX updates.
     * @since 1.1.7
     */
    public $updateSelector;
    /**
     * @var string a javascript function that will be invoked if an AJAX update error occurs.
     *
     * The function signature is <code>function(xhr, textStatus, errorThrown, errorMessage)</code>
     * <ul>
     * <li><code>xhr</code> is the XMLHttpRequest object.</li>
     * <li><code>textStatus</code> is a string describing the type of error that occurred.
     * Possible values (besides null) are "timeout", "error", "notmodified" and "parsererror"</li>
     * <li><code>errorThrown</code> is an optional exception object, if one occurred.</li>
     * <li><code>errorMessage</code> is the CGridView default error message derived from xhr and errorThrown.
     * Usefull if you just want to display this error differently. CGridView by default displays this error with an javascript.alert()</li>
     * </ul>
     * Note: This handler is not called for JSONP requests, because they do not use an XMLHttpRequest.
     *
     * Example (add in a call to CGridView):
     * <pre>
     *  ...
     *  'ajaxUpdateError'=>'function(xhr,ts,et,err){ $("#myerrordiv").text(err); }',
     *  ...
     * </pre>
     */
    public $ajaxUpdateError;
    /**
     * @var string the name of the GET variable that indicates the request is an AJAX request triggered
     * by this widget. Defaults to 'ajax'. This is effective only when {@link ajaxUpdate} is not false.
     */
    public $ajaxVar='ajax';
    /**
     * @var mixed the URL for the AJAX requests should be sent to. {@link CHtml::normalizeUrl()} will be
     * called on this property. If not set, the current page URL will be used for AJAX requests.
     * @since 1.1.8
     */
    public $ajaxUrl;
    /**
     * @var string a javascript function that will be invoked before an AJAX update occurs.
     * The function signature is <code>function(id)</code> where 'id' refers to the ID of the list view.
     */
    public $beforeAjaxUpdate;
    /**
     * @var string a javascript function that will be invoked after a successful AJAX response is received.
     * The function signature is <code>function(id, data)</code> where 'id' refers to the ID of the list view
     * 'data' the received ajax response data.
     */
    public $afterAjaxUpdate;
    /**
     * @var string the base script URL for all list view resources (e.g. javascript, CSS file, images).
     * Defaults to null, meaning using the integrated list view resources (which are published as assets).
     */
    public $baseScriptUrl;
    /**
     * @var string the URL of the CSS file used by this list view. Defaults to null, meaning using the integrated
     * CSS file. If this is set false, you are responsible to explicitly include the necessary CSS file in your page.
     */
    public $cssFile;
    /**
     * @var string the HTML tag name for the container of all data item display. Defaults to 'div'.
     * @since 1.1.4
     */
    public $itemsTagName='table';

    /**
     * @var boolean whether to leverage the {@link https://developer.mozilla.org/en/DOM/window.history DOM history object}.  Set this property to true
     * to persist state of list across page revisits.  Note, there are two limitations for this feature:
     * - this feature is only compatible with browsers that support HTML5.
     * - expect unexpected functionality (e.g. multiple ajax calls) if there is more than one grid/list on a single page with enableHistory turned on.
     * @since 1.1.11
     */
    public $enableHistory=false;

    public function init()
    {
        parent::init();
    }
    /**
     * Renders the data item list.
     */
    public function renderItems()
    {
        echo CHtml::openTag($this->itemsTagName,array('class'=>$this->itemsCssClass))."\n";
        $data=$this->dataProvider->getData();
        if(($n=count($data))>0)
        {
            $owner=$this->getOwner();
            $viewFile=$owner->getViewFile($this->itemView);
            $j=0;
            $c = 1;
            echo '<tr>';
            foreach($data as $i=>$item)
            {

                $data=$this->viewData;
                $data['index']=$i;
                $data['data']=$item;
                $data['widget']=$this;
                $owner->renderFile($viewFile,$data);
                if($j++ < $n-1)
                    echo $this->separator;

                if($c%2==0)
                {
                    echo '</tr><tr>';
                }
                $c++;
            }
            echo '</tr>';
        }
        else
            $this->renderEmptyText();
        echo CHtml::closeTag($this->itemsTagName);
    }

}