$(function(){





$(".close-alert").click(function(){
		$(this).parents(".alert").css({"display":"none"});
	});

    // Drag and Drop Jquery

    $( init );

	function init() {
		/*
	  $( ".sortList" ).sortable({
	  stop: function(e, ui) {

            $(".alert").show();
            $(".alert").addClass("alert-success").removeClass("alert-info");
            $(".alert-note").text("Done!");
            $(".msg-alert").text("Changes are updated successfully.");

          }
	  });
	  */
	  $( ".panel-daggable" ).sortable({
	  stop: function(e, ui) {
			var sections = new Array();
			var subSections = new Array();

			var i=0;
			$sections = $('.oSection').each(function(){
				sections[i]=$(this).data('id');
				var j=0;
				subSections[i] = new Array();
				$(this).find('.oSubSection').each(function(){

					subSections[i][j] = $(this).data('id');
					j++;
				});
				i++;
			});

			var postData = {
				sections:sections,
				subSections:subSections,
				_token:$('[name="_token"]').val()
			};
			//console.log(postData);

			$.post($('#accordion').data('url'),postData, function(data, status){
			    	if(data==1){
						$.notify("Reorder Updated.", {"status":"success"});
					} else {
						$.notify("Reorder Not Updated.", {"status":"danger"});
					}



			  });

          }
	  });
	}

	$('#expandAll').on('click', function()
	{
		$('.sections-box').find('.panel-collapse').addClass('show');
	});
	$('#collapseAll').on('click', function()
	{
		$('.sections-box').find('.panel-collapse').removeClass('show');
	});
	//loader
	$(function()
	{
   		setTimeout(function()
   			{
   				$('.customLoader').fadeOut();
   			}, 1000);

	});
});



function formatOption(state) {
	if (!state.id) return state.text; // optgroup

	var originalOption = state.element;

	var option = "<span style='display:inline-block;' class='show_box'><img class='mr-2 rounded' src='" + $(originalOption).data('image') + "' /></span>"+ state.text +" <span>("+$(originalOption).data('stype')+")</span>";
	return option;
	//console.log(state.text);
}
$(".ctSelectBox").select2({
	templateResult: formatOption,
	//formatSelection: format,
	escapeMarkup: function(m)
	{
		return m;
	}
});
var deletcount=1;
function changedata(m)
{
	var audioBookName =$( "#showselection option:selected" ).text();
	var audioBookId = $(m).val();
	var audiobookImageUrl = $('option:selected', m).attr('data-image');
	var audiobookImageHtml = '<div class="col-sm-10"><img src="'+audiobookImageUrl+'" class="align-self-end show_box mr-3 '+audioBookId+'" alt="'+audioBookName+'">'+audioBookName+'</div>';
	var deleteBtn = '<div class="col-sm-1 text-right"><button class="del_btn" data-id="'+audioBookId+'" onclick="delselcted('+deletcount+')"><i class="fa fa-close"></i></button></div>';
	//var checkBox = '<input type="checkbox" class="form-group float-right largerCheckbox" id="audiobook_sample_'+audioBookId+'" name="sample_data">&nbsp';

	var checkBox = '<div class="col-sm-1 text-right"><div class="custom-control custom-checkbox mt-11"><input type="checkbox" class="custom-control-input" id="audiobook_sample_'+audioBookId+'"><label class="custom-control-label" for="audiobook_sample_'+audioBookId+'"></label></div></div>'


	htmlContent = '<li class="list-group-item mt-2 selectioncount'+deletcount+'" data-id="null" data-type="<?= SectionContent::TYPE_AUDIOBOOK ?>" data-contentId="'+audioBookId+'"><div class="row">'+audiobookImageHtml+checkBox+deleteBtn+'</div></li>';
	$("#sectionContent").append(htmlContent);
	$(".submit-btn").show();
	deletcount++;
};

function delselcted(i)
{
	$('.selectioncount'+i).remove();
}




/***********TEAM LOGO THUMBNAIL******/



function readteamURL(teamlogo) {
	if (teamlogo.files && teamlogo.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
			$('#blah_team').attr('src', e.target.result);
		}

		reader.readAsDataURL(teamlogo.files[0]); // convert to base64 string
	}
}

$("#imgInp_team").change(function() {
	readteamURL(this);
	$('.del_btn_team').show();
});

$("#delet_team_photo").click(function()
{
	$('#blah_team').attr('src',"img/avatarEmpty.png");
	$('.del_btn_team').hide();
});


/***********TEAM LOGO THUMBNAIL******/


function readplayerURL(player) {
	if (player.files && player.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
			$('#blahplayer').attr('src', e.target.result);
		}

		reader.readAsDataURL(player.files[0]); // convert to base64 string
	}
}

$("#imgInpplayer").change(function() {
	readplayerURL(this);
	$('.del_btn_player').show();
});

$("#delet_player").click(function()
{
	$('#blahplayer').attr('src',"img/avatarEmpty.png");
	$('.del_btn_player').hide();
});
