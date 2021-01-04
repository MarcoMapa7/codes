<hr>
<div class='tpl col-md-12'><h2>{(title)} - {(sku)} ({(id)})</h2></div>
<div class='tpl col-md-12'><strong>Description:</strong><p>{(description)}</p></div>

<div style="clear:both" class="paddbottom"></div>

<div class='tpl col-md-12'><strong>HTML Page Code:</strong><div style="width:100%; border:1px solid #eee; padding:15px;" >{(html_override)}</div></div>

<div style="clear:both" class="paddbottom"></div>

<div class='tpl col-md-3'><strong>SKU: </strong>{(sku)}</div>
<div class='tpl col-md-3'><strong>Initial Price: </strong>{(base_price)}</div>
<div class='tpl col-md-3'><strong>Category: </strong>{(product_category_id)}</div>
<div class='tpl col-md-3'><strong>Brand: </strong>{(brand_id)}</div>


<div style="clear:both" class="paddbottom"></div>

<div class='tpl col-md-4'><strong>Viewed: </strong>{(view_counter)} </div>
<div class='tpl col-md-4'><strong>Ordered: </strong>{(order_counter)} </div>
<div class='tpl col-md-4'><strong>Added On: </strong>{(added)}</div>

<div style="clear:both" class="paddbottom"></div>

<div class='tpl col-md-12'><strong>URL: </strong>{(seo_url)}</div>

<div style="clear:both" class="paddbottom"></div>

<div class='tpl col-md-6'><strong>Parameters: </strong>{(parameters)}</div>
<div class='tpl col-md-6'><strong>images: </strong>

<form id="image1" method="post" enctype="multipart/form-data"><input name="image1" type="file" /><input type="hidden" name="prodId" value="{(id)}"><button>Submit</button></form><div id="image1container"></div>
<form id="image2" method="post" enctype="multipart/form-data"><input name="image2" type="file" /><input type="hidden" name="prodId" value="{(id)}"><button>Submit</button></form><div id="image2container"></div>
<form id="image3" method="post" enctype="multipart/form-data"><input name="image3" type="file" /><input type="hidden" name="prodId" value="{(id)}"><button>Submit</button></form><div id="image3container"></div>
<form id="image4" method="post" enctype="multipart/form-data"><input name="image4" type="file" /><input type="hidden" name="prodId" value="{(id)}"><button>Submit</button></form><div id="image4container"></div>
<form id="image5" method="post" enctype="multipart/form-data"><input name="image5" type="file" /><input type="hidden" name="prodId" value="{(id)}"><button>Submit</button></form><div id="image5container"></div>

</div>
<div class='tpl col-md-12' style="text-align:right">{((operations))}</div>
