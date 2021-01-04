;// JavaScript Document
	$(document).ready(function(e) {

	$("body").on("click",".add-update-agent",function(e) {
				
				

//				e.preventDefault();
//				e.stopImmediatePropagation();
//				e.stopPropagation();
				var tbl = $(this).attr("data-tbl");
				var dr= $(this).attr("data-records");
				var action= $(this).attr("data-action");
				var dataid = $(this).attr("data-action");				
				var formid = "#"+tbl + "_table";
				//$(formid).submit();
				/*$(formid).on("submit",function(e) {
				
				if(!$(formid)[0].checkValidity())
					alert("Fix");
			
				var formData = $(formid).serialize();
			
				var target ;
				if(action == 'add')
					target = "?ajax=true&action=addRecord&id="+dataid+"&identifier="+tbl;
					
				if(action == 'update')
					target = "?ajax=true&action=updateRecord&id="+dataid+"&identifier="+tbl;
					
				$.ajax({
				url:target,
				type:"POST",
				async:true,
				cache:false,
				success: function(data) {
					if(data=='true')
					{
						//alert(dr);
						//$(".crud360-form-msg").html(data);
						$(".crud360-form-msg").html('<div class="alert alert-info">Record deleted successfully</div>');
						//$("#"+row).css("background","#fcc");
						//$("#"+row).css("display","none");
						$("#"+dr).load("?ajax=true&action=renderRecords&id=1&identifier="+tbl);
					}
					else
					{
						//console.log(data);
						$(".crud360-form-msg").html(data);
						//$(".crud360-form-msg").html('<div class="alert alert-danger">'+data+' Please try again!</div>');
					}
					$('.alert').fadeTo(5000, 500).slideUp(500, function(){
					$('.alert').slideUp(500);
					});
	
				}
				

			});



		});	*/
	});

		$("body").on("click",".operations .btn-info",function(e) {
				var id = $(this).attr('data-id');
				var row = $(this).attr("data-rowid");
				var tbl = $(this).attr("data-tbl");
				var qs = $(this).attr("data-qs");
				
				//$("#crud360-form").load("?ajax=true&action=updateForm&id="+id);	
				$.ajax({
					url:"?"+qs+"&ajax=true&action=updateForm&id="+id+"&identifier="+tbl,
					type:"GET",
					async:true,
					cache:false,
					success: function(data) { $("#crud360-form-"+tbl).show(); $("#crud360-form-"+tbl).html(data);}									
					});
			});	
		
			$("body").on("click",".btn-close-update",function(e) {
				var tbl = $(this).attr("data-tbl");
					$("#crud360-form-"+tbl).hide();
			});

    });
	
//+++++++++++++++++++++++++++ COMMON JS +++++++++++++++++++++++++++++++++++//
	$("body").on("click",".operations .btn-warning",function(e) {
		$(window).scrollTop(0);
		var qs = $(this).attr("data-qs");
		var delete_msg = "<div align='center'><p class='delete-notice'>Are you sure to delete record from '"+$(this).attr("data-tbl-title")+"' at SR# "+$(this).attr("data-serial")+" having database ID# "+$(this).attr("data-id")+"?</p><button id='crud360-delete-button-cancel' type='button' class='btn btn-default'>Cancel</button><span style='margin-right:15px'></span>"
									+"<button id='crud360-delete-button' type='button' data-rowid="+$(this).attr("data-rowid")+" data-pk='"+$(this).attr("data-pk")+"' data-qs='"+qs+"' data-id='"+$(this).attr("data-id")+"' data-records='"+$(this).attr("data-records")+"' data-tbl='"+$(this).attr("data-tbl")+"' data-tbl-title="+$(this).attr("data-tbl-title")+" class='btn btn-danger'>Delete</button></div>";
		$(".crud360-form-delete").html(delete_msg);
		$(".crud360-form-delete").show();
    });

	$("body").on("click","#crud360-delete-button-cancel",function(e) {
		$(".crud360-form-delete").hide();
	});

	$("body").on("click","#crud360-delete-button",function(e) {
		

		$(".crud360-form-delete").hide();
		var row = $(this).attr("data-rowid");
		var tbl = $(this).attr("data-tbl");
		var id = $(this).attr("data-id");
		var dr= $(this).attr("data-records");
		var qs = $(this).attr("data-qs");
		var full_link = "?"+qs+"&ajax=true&action=delete&id="+id+"&identifier="+tbl;
		//console.log(full_link);
		$.ajax({		

			url:full_link,
			type:"GET",
			async:true,
			cache:false,
			success: function(data) {
				if(data=='true')
				{
					//$(".crud360-form-msg").html(data);
					$(".crud360-form-msg").html('<div class="alert alert-info">Record deleted successfully</div>');
					//$("#"+row).css("background","#fcc");
					//$("#"+row).css("display","none");
					$("#"+dr).load("?"+qs+"&ajax=true&action=magic&id=1&identifier="+tbl);
				}
				else
				{
					console.log(data);
					$(".crud360-form-msg").html(data);
					
						var td =  $('.crud360-records-video').parent("td").width();
     $('.crud360-records-video').css({
        'width': td-5+"px", 
    });
	
	var td =  $('.crud360-records-img').parent("td").width();
     $('.crud360-records-img').css({
        'width': td-5+"px", 
    });


					
					
					//$(".crud360-form-msg").html('<div class="alert alert-danger">'+data+' Please try again!</div>');
				}
				$('.alert').fadeTo(5000, 500).slideUp(500, function(){
				$('.alert').slideUp(500);
				});

			}
		});
		

		
		
		
   	});
		
//--------------------------- COMMON JS -----------------------------------//

function fixImgVid()
{
	var td =  $('.crud360-records-video').parent("td").width();
     $('.crud360-records-video').css({
        'width': td-5+"px", 
    });
	
	var td =  $('.crud360-records-img').parent("td").width();
     $('.crud360-records-img').css({
        'width': td-5+"px", 
    });


	var div =  $('.crud360-records-video').parent("div").width();
     $('.crud360-records-video').css({
        'width': div-5+"px", 
    });
	
	var div =  $('.crud360-records-img').parent("div").width();
     $('.crud360-records-img').css({
        'width': div-5+"px", 
    });

	$(".records-tpl .crud360-records-img, .records-tpl .crud360-records-video").each(function(index, element) {
        //alert($(this).height());
		//alert($(".crud360-records-img").height());
		$(this).parent("div").height($(this).height());

		$(this).width($(this).width()+5);
    });
	
	
	
}

$(window).resize(function(){
	//$("img,video").hide();
	fixImgVid();
	//$("img,video").show();
}).resize();



$("body").on("keyup",".search-filter", function(e) {
	$("body .pagination-trigger").trigger("click"); 
});

$("body").on("click",".pagination-trigger", function(e) {
	var d_tbl = $(this).attr("data-tbl");
	var d_limit = $(this).attr("data-limit");
	var d_qs = $(this).attr("data-qs");
	var d_id = $(this).attr("data-id");
	var sq = "#" + d_tbl + "-search-query";
	var sqv = $(sq).val();
	var url = "?"+d_qs+"&ajax=true&action=magic&id="+d_limit+"&identifier="+d_tbl+"&"+d_tbl+"_search_query="+sqv;
	$("#"+d_id).html("<p align='center' style='padding:15px''><img src='crud360/img/squares.svg'><br>Loading...</p>");
	$.ajax({
		type:"GET",
		async:true,
		cache:false,
		url:url,
		success: function(data) {
			$("#"+d_id).html(data);
			fixImgVid();

		}
	});
	
	/*$("#"+d_id).load("?"+d_qs+"&ajax=true&action=magic&id="+d_limit+"&identifier="+d_tbl);*/

});



/*$("body").on("click",".search-filter-button", function(e) {
	
	var tbl =  $(this).attr("data-tbl");
	var sq =  tbl+"-search-query";
	
	$("#records_" + tbl + "_div"+ " .pagination-trigger").trigger("click");
	
	//alert($("#"+sq).val());	
	
	/*var d_tbl = $(this).attr("data-tbl");
	var d_limit = $(this).attr("data-limit");
	var d_qs = $(this).attr("data-qs");
	var d_id = $(this).attr("data-id");
	
	$("#"+d_id).html("<p align='center' style='padding:15px''><img src='crud360/img/squares.svg'><br>Loading...</p>");
	$.ajax({
		type:"GET",
		async:true,
		cache:false,
		url:"?"+d_qs+"&ajax=true&action=magic&id="+d_limit+"&identifier="+d_tbl,
		success: function(data) {
			$("#"+d_id).html(data);
			fixImgVid();

		}
	});

	console.log($(this).val());

});*/