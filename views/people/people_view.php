<?php $this->load->view('partial/left_panel'); ?>
<script type="text/javascript">

      var change_page = function(next){
        var length = $('.search_circle').length;
        var current = 1;
        for(i=0;i<length;i++){
          if($($('.search_circle')[i]).attr('class') == "search_circle select"){
            current = i+1;
          }
        }
        if(next == "right"){
          if(current != length){
            get_page(current+1);
          }
        }
        else{
          if(current != 1){
            get_page(current-1);
          }
          
        }

      }

      var get_page = function(id){
        $('.search_paging').hide();
        $('#search_page_'+id).show();
        $('.search_circle').removeClass('select');
        $('#ciricle_'+id).addClass('select');
        return false;
      }
    $(document).ready(function(){
      
		$("#search_header").keyup(function(event){
			if(event.keyCode == 13){
				$('#search_bttn').trigger('click');    
			}
		});

		$('#search_bttn').click(function(){
			val = $('#search_header').val();
			$.ajax({
			  url: '<?php echo base_url(); ?>feed/search',
			  dataType: 'json',
			  data:{
			    "term":val,
			  },
			  success: function(data){
			    var html = "";
			    var counter = 0;
			    var show_on = 8; // shows at max 8 
			    var pages = 1;

			    if(data.status == "success"){
			      $('.result_text_').html(val);
			      html +='<div class="search_paging" id="search_page_'+pages+'" style="display:block;">';
			      for(var i=0; i< data.users.length; i++){
			        ud = data.users[i];
			        if(counter%show_on == 0  && counter!=0){
			           pages ++;
			           html += '</div><div class="search_paging" id="search_page_'+pages+'" style="display:none;">';
			        }
			        counter ++ ;
			        html +=' <div class="result_box">';
			        html +='   <div class="result_box1">';
			        html +='         <div class="result_imgBox"> ';
			        html +='             <img src="'+ud.picture_url_thumb+'" style="height:48px; width:48px;" alt="">';
			        html +='         </div>';
			        html +='         <p>';
			        html +='           <b style="font-size:16px; font-weight:bold; color:#000;">';
			        html +=              ud.first_name+' '+ud.last_name;
			        html +='           </b><b>'+ud.job_title+'</b></p>';
			        html +='         <br clear="all" />';
			        html +='     </div>';
			        html +='     <div class="right_arow2">';
			        html +='       <a href="home?user_id='+ud.id+'">';
			        html +='         <img src="<?php echo base_url(); ?>assets/images/main_images/right_arow_btn4.png" alt="" />';
			        html +='       </a>';
			        html +='     </div>';
			        html +=' </div>';
			      }
			      
			      html += '</div>'
			      $('._search_results').html(html);
			      
			      html = '';
			      for(var i=0; i<pages;i++){
			        if(i==0){
			          html += '<a href="#" onclick="get_page('+(i+1)+')" id="ciricle_'+(i+1)+'" class="select search_circle"></a>';
			        }
			        else{
			          html += '<a href="#" onclick="get_page('+(i+1)+')" id="ciricle_'+(i+1)+'" class="search_circle"></a>';
			        }
			      }
			      html += '<br clear="all" />';
			      $('.result_slid_btns').html(html);
			      $('.search_results').show();            
			    }
			  }
			});
  		});
		function SortByName(a, b){
		  var aName = a.name.toLowerCase();
		  var bName = b.name.toLowerCase(); 
		  return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
		}
		
		SortButton = function(type){
			$('.sort_bttn').removeClass('selected');
			if(type == 'name'){
				$('#sort_by_name').addClass('selected');
			}else{
				$('#sort_by_title').addClass('selected');
			}
			var len = $('.people_info_div').length;
			var data = [];
			var ele = {};
			for(var i=0;i<len;i++){
				if(type == 'name'){
					ele.name = $($('.people_info_div')[i]).children().children().children('p').children('span').html();
				}else{
					ele.name = $($('.people_info_div')[i]).children().children().children('p').children('b').html();
				}
				ele.html = $('.people_info_div')[i];

				data.push(ele);
				ele = {};
			}
			data_user = data.sort(SortByName);
			html = "<div>";
			for(var i=0;i<len;i++){
			    html += data_user[i].html.outerHTML;
			}
			html += '<br clear="all" /></div>';
			$('.accounting_container').html(html);
		}
		SortButton('name');
	});

</script>

<div class="main-wrapper">
	<div class="span9">
		<div style="max-width:724px">
			<div class="selected_users">
	
    			<div class="search_container2">
		        	<div id="search_bttn" style="position:absolute; height:32px; width:0px;"></div>
      				<div>
			         	 <input placeholder="Search People" id="search_header"/>
			     	 </div>
			  	</div>
		    	<a href="#" onclick="SortButton('name'); return false;" class="sort_bttn member_btn selected margin_r" id="sort_by_name">Sort by Name</a>
		        <a href="#" class="sort_bttn member_btn margin_r">Sort by Group</a>
		        <a href="#"  onclick="SortButton('title'); return false;" class="sort_bttn member_btn" id="sort_by_title">Sort by Title</a>
		        <br clear="all" />
		    </div>
		    <div class="search_results" style="display:none;">
		      <div class="post_down_arrow left_610px">
		        <img src="<?php echo base_url(); ?>assets/images/main_images/post_down_arrow.png" alt="" />
		      </div>
		        <div class="result_text">
		            Results for “<span class="result_text_"></span>”
		        </div>
		        <div class="schedul_conatainer _search_results">
		          
		        </div>
		        <br clear="all" />
		        <div class="pagging">
		            <div class="result_slid_btns">
		            </div>
		            <a href="#" onclick="change_page('left'); return false;" class="pagging_left_btn">&lt;</a>
		            <a href="#" onclick="change_page('right'); return false;" class="pagging_left_btn border_non ">&gt;</a>
		        </div>
		      </div>

		   <div class="accounting_container">
		       <div>

		       <?php	$au = $all_users['user']; ?>
			   <?php foreach($au as $userv ){ ?>
			        <a href='home?user_id=<?php echo $userv['id']; ?>' class="people_info_div">
			        	<div class="user_box2" user-id="<?php echo $userv['id']; ?>">
			        		<div class="user_info_text2">
			                	<div class="user_imgBox">	
			                		<img src="<?php echo base_url(); ?>assets/images/profile_images/profiles_<?php echo $userv['id']%80;?>.png" alt="" style="position:absolute; left:0px; z-index:10;">
			                    	<img src="<?php echo $userv['picture_url_thumb']; ?>" alt="" style="position:absolute; left:0px; z-index:100;">
			                	</div>
				                <p><span><?php echo $userv['first_name']; ?> <?php echo $userv['last_name']; ?></span><b style="height:20px; overflow:hidden;"><?php echo $userv['job_title']; ?>, <?php echo $userv['department']; ?></b></p>
				                <br clear="all" />
				            </div>
			        	</div>
			        </a>
		     	<?php } ?>
		      	<br clear="all" />
		      </div>
		   </div>
		</div>
	</div>
</div>
<?php $this->load->view("partial/right_panel_small"); ?>