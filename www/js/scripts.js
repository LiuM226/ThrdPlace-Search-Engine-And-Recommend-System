var Cufon;
Cufon.replace('.din.bold', { fontFamily: 'DINOT-Bold', hover: true });

// When the document loads...
jQuery(document).ready(function($) {

  var tag;
  // The slider on the home page
  $('.featuredSlider').bxSlider({
    mode: 'fade',
    auto: true,
    controls: false
  });

  // Make it stick!

  // Add class to remove margins
  $('section.process > div > div:first').addClass('first');

  // Featured projects slider
  $('.featuredProjects .sliderWrap').bxSlider({
    displaySlideQty: 3,
    moveSlideQty: 1,
    controls: true
  });

  function goToByScroll(id){
    // Remove "link" from the ID
    id = id.replace("link", "");
    // Scroll
    $('html,body').animate({
      scrollTop: $("#"+id).offset().top - 200},
    'slow');
  }


  $('.iconhome').click(function(e) {
    // Prevent a page reload when a link is pressed
    e.preventDefault(); 
    // Call the scroll function
    goToByScroll($(this).attr("id"));           
    return false;
  });

  var profitsSlider = 
    $('#profitSlider').bxSlider({
      mode: 'fade',
      controls: false,
      speed: 100,
      onBeforeSlide: function(currentSlideNumber, totalSlideQty, currentSlideHtmlObject) {
        
        var rel = currentSlideHtmlObject.attr('rel');
        currentSlideHtmlObject.parents('.landingSection').css('background-color', rel);
    }
  });

  var npSlider = 
  $('#nonProfitSlider').bxSlider({
    mode: 'fade',
    controls: false,
    speed: 100,
    onBeforeSlide: function(currentSlideNumber, totalSlideQty, currentSlideHtmlObject) {

      var rel = currentSlideHtmlObject.attr('rel');
      currentSlideHtmlObject.parents('.landingSection').css('background-color', rel);
    }
  });

  var govtSlider = 
  $('#govtSlider').bxSlider({
    mode: 'fade',
    controls: false,
    speed: 100,
    onBeforeSlide: function(currentSlideNumber, totalSlideQty, currentSlideHtmlObject) {

      var rel = currentSlideHtmlObject.attr('rel');
      currentSlideHtmlObject.parents('.landingSection').css('background-color', rel);
    }
  });

  var indSlider = 
  $('#indSlider').bxSlider({
    mode: 'fade',
    controls: false,
    speed: 100,
    onBeforeSlide: function(currentSlideNumber, totalSlideQty, currentSlideHtmlObject) {

      var rel = currentSlideHtmlObject.attr('rel');
      currentSlideHtmlObject.parents('.landingSection').css('background-color', rel);
    }
  });                           

  $('.go-prev').click(function() {
    var rel = $(this).attr('rel');
    if (rel === 'profitSlider') {
      profitsSlider.goToPreviousSlide();
    }
    else if (rel === 'nonProfitSlider') {
      npSlider.goToPreviousSlide();
    }
    else if (rel === 'indSlider') {
      indSlider.goToPreviousSlide();
    }
    else {
      govtSlider.goToPreviousSlide();
    }
    return false;
  });
  $('.go-next').click(function() {
    var rel = $(this).attr('rel');
    if (rel === 'profitSlider') {
      profitsSlider.goToNextSlide();
    }
    else if (rel === 'nonProfitSlider') {
      npSlider.goToNextSlide();
    }
    else if (rel === 'indSlider') {
      indSlider.goToNextSlide();
    }
    else {
      govtSlider.goToNextSlide();
    }
    return false;
  });


  // Add class to remove margins
  $('.sliderWrap .project:even').addClass('even');

  // Tabs
  $('div.tab').hide();
  $('div.tab:first').show().addClass('active');
  $('div.tabs a:first').addClass('active');

  $('div.tabs a').bind('click', function() {
    var currentTab = $(this).attr('href');

    $('div.tabs a').removeClass('active');
    $('div.tab').removeClass('active');

    $('div.tab').hide();
    $(currentTab).show();
    $(this).addClass('active');

    return false;
  });

  // The sidebar - Map
  $('#side-nav .accordion-button').bind('click', function() {
    $('.accordion-button.selected').not(this).removeClass('selected');
    $(this).toggleClass('selected');

    if ( $(this).hasClass('selected') ) {
      $(this).find('span.icon').html('-');
    } else {
      $(this).find('span.icon').html('+');
    }

    $('#side-nav .accordion-content').stop().slideUp('normal');
    $(this).next().stop().slideToggle('normal');
  });

  // -- END sidebar map code

  // How to start - video pop up

  $('.fancybox-media').fancybox({
    width: 800,
    height: 450,
    openEffect  : 'elastic',
    closeEffect : 'fade',
    type: 'iframe',
    fitToView : false,
    helpers : {
      overlay : {
        opacity: 0.8,
        css : {
          'background': 'rgba(42, 42, 42, 0.80)'
        }
      }
    }
  });

  $('a.signUp').fancybox({
    width: 700,
    openEffect  : 'elastic',
    closeEffect : 'fade',
    scrolling : 'no',
    helpers : {
      overlay : {
        opacity: 0.8,
        css : {
          'background': 'rgba(42, 42, 42, 0.80)'
        }
      }
    }
  });

  $('.createProject').fancybox({
    href: '#start-a-project',
    type: 'inline',
    width: 700,
    openEffect: 'elastic',
    closeEffect: 'fade',
    scrolling : 'no',
    helpers : {
      overlay : {
        opacity: 0.8,
        css : {
          'background': 'rgba(42, 42, 42, 0.80)' 
        }
      }
    }
  });

  $("#show-feedback a").fancybox({
    openEffect  : 'elastic',
    closeEffect : 'fade',
    helpers : {
      overlay : {
        opacity: 0.8,
        css : {
          'background': 'rgba(42, 42, 42, 0.80)' 
        }
      }
    }
  });

  $('#show-partner-form a').fancybox({
    openEffect  : 'elastic',
    closeEffect : 'fade',
    scrolling : 'yes',
    helpers : {
      overlay : {
        opacity: 0.8,
        css : {
          'background': 'rgba(42, 42, 42, 0.80)' 
        }
      }
    }
  });

  $('#show-open-projects').fancybox({
    autoSize: false,
    width: 700,
    scrolling : 'yes',
    openEffect  : 'elastic',
    closeEffect : 'fade',
    helpers : {
      overlay : {
        opacity: 0.8,
        css : {
          'background': 'rgba(42, 42, 42, 0.80)' 
        }
      }
    }
  });

  // Add din bold to table cells

  $('table.projectList th').addClass('din bold');
  $('table.projectList td').addClass('din');
  $('table.projectList td.needs').removeClass('din bold');

  /* Partner back-end */
  $('#selectAll').click(function () {
    $('.creators').prop('checked', true);
    return false;
  });

  fill_autocomplete = function(source) {
    function split( val ) {
      return val.split( /,\s*/ );
    }
    function extractLast( term ) {
      return split( term ).pop();
    }

    $( "input#autocomplete" )
    // don't navigate away from the field on tab when selecting an item
    .bind( "keydown", function( event ) {
      if ( event.keyCode === $.ui.keyCode.TAB &&
        $( this ).data( "autocomplete" ).menu.active ) {
          event.preventDefault();
        }
    })
    .autocomplete({
      minLength: 0,
      source: function( request, response ) {
        // delegate back to autocomplete, but extract the last term
        response( $.ui.autocomplete.filter(
          source, extractLast( request.term ) ) );
      },
      focus: function() {
        // prevent value inserted on focus
        return false;
      },
      select: function( event, ui ) {
        var terms = split( this.value );
        // remove the current input
        terms.pop();
        // add the selected item
        terms.push( ui.item.value );
        // add placeholder to get the comma-and-space at the end
        terms.push( "" );
        this.value = terms.join( ", " );
        return false;
      }
    });
  };

  $('.impact-summary').click(function() {
    $('#side-nav').toggle();
    return false;
  });

  $('input#searchTags').click(function() {
    var selected_tags = $( "input#autocomplete" ).val();
    if (selected_tags === '') {
      window.location.reload();
      return false;
    }
    var post_url = window.location.protocol + "//" + window.location.host + '/partners/search';
    // remove trailing comma.. need to clean this up eventually
    var trim = selected_tags.replace(/(,\s*$)/g, "");
    $.ajax({
      type: "POST",
      url: post_url,
      dataType: "json",
      data: {
        tags: trim,
        filter: $('div#filter').attr('value')
      }
    }).done(function(res) {
      $("table#projectSearch tr:first").siblings().remove();
      var str = '';
      for (var i= 0; i < res.length; i++) {
        var project_url = window.location.protocol + "//" + window.location.host + "/projects/display/";
        var money_needed;
        if (res[i]['Project']['money_rem'] > 0) {
          money_needed = "<span class=\"funds active\"></span>";
        }
        else {
          money_needed = "<span class=\"funds\"></span>";
        }
        if (res[i]['Project']['volunteers_needed'] > 0) {
          vols_needed = "<span class=\"volunteers active\"></span>";
        }
        else {
          vols_needed = "<span class=\"volunteers\"></span>";
        }
        if (res[i]['Project']['supplies_needed'] > 0) {
          sups_needed = "<span class=\"supplies active\"></span>";
        }
        else {
          sups_needed = "<span class=\"supplies\"></span>";
        }
        str +=
        "<tr><td class=\"select\"><input class=\"creators\" name=\"creators\"" +
          "email=\""+res[i]['Project']['user_email']+"\" type=\"checkbox\">"+
          res[i]['Project']['username']+"</td>"+
          "<td><a href=\""+project_url+res[i]['Project']['id']+"\" class=\"din bold\">"+
          res[i]['Project']['title']+"</a></td>" +
          "<td class=\"featured\"><input type=\"checkbox\"></td>"+
          "<td>"+res[i]['Project']['city']+", "+res[i]['Project']['state']+"</td>"+
          "<td>"+res[i]['Project']['resources_per']+"%</td>" +
          "<td class=\"needs\">"+money_needed+vols_needed+sups_needed+"</td></tr>";
      }
      $("table#projectSearch tr:first").after(str);
      $('table.projectList th, table.projectList td').addClass('din bold');

    });
  });

  $('#login-submit').click(function() {
    var create = $('#create_flag').attr('redirect');
    var create_url =  window.location.protocol + "//" + window.location.host + '/projects/manage';
    var username = $('#login_user').val();
    var pass = $('#login_password').val();
    var login_url =  window.location.protocol + "//" + window.location.host + '/users/login';
    if (tag) {
      create_url = create_url + "?tag=" + tag;
    }
    $.ajax({
      type: "POST",
      url: login_url,
      data: {
        username: username,
        password: pass
      }
    }).done(function(msg) {
      var response = jQuery.parseJSON(msg);
      if (!jQuery.isEmptyObject(response) && response.error.length > 0) {
        $("#login-error").text(response.error);
      }
      else {
        if (create === 'true') {
          $('#create_flag').attr('redirect', '');
          $('#createproject2').remove('createProject2');
          window.location.href = create_url;
        }
        else {
          $('#start-a-project').toggle();
          window.location.reload();
        }
      }
    });
  });

  var userName = "";
	var userLocation = "";
	$('#login-btn').click(function(){
		var email = $('#email-input').val();
		var pwd = $('#pwd-input').val();
				
		var request = $.ajax({
			type:"POST",
			url: "php/login.php",
			data: {email:email, password:pwd}
		});
		request.done(function(json){
			var response = eval("("+ json + ")");
			userName = response.user.name;
			userLocation = response.user.location;
			//alert(userName + " " + userLocation);
			if(userName !== "" && userLocation !== ""){
				// $('#username').html(response.user.name);
				// $('#userlocation').html(response.user.location);		
        window.location.href = "./php/search2.php?name=" + userName + "&location=" + userLocation;	
			}
			else{
				$('#username').html("Error");
				$('#userlocation').html("Error");
			}
		});

    });
	
	$('#search-btn').click(function(){
		// alert(userLocation);
	  window.location.href = "./php/search2.php?name=" + userName + "&location=" + userLocation;
	});
  
  
  
  
  $('#signup-submit').click(function() {
    var username = $('#register_user').val();
    var email = $('#register_email').val();
    var first_name = $('#first_name').val();
    var last_name = $('#last_name').val();
    var pass = $('#register_password').val();
    var pass2 = $('#register_password2').val();
    var loc = $('#register_location').val();
    var create = $('#create_flag').attr('redirect');
    var create_url =  window.location.protocol + "//" + window.location.host + '/projects/manage';
    $.ajax({
      type: "POST",
      url: '/users/register',
      data: {
        username: username,
        first_name: first_name,
        last_name: last_name,
        password: pass,
        password2: pass2,
        email: email,
        location: loc
      }
    }).done(function(msg) {
      var response = jQuery.parseJSON(msg);
      if (response.error) { 
        $("#error-register").text(response.error);
      }
      else {
        $('#start-a-project').toggle();
        if (create === 'true') {
          $('#create_flag').attr('redirect', '');
          window.location.href = create_url;
        }
        else {
          window.location.reload();
        }
      }
    });
  });

   function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
  }
 

  $('#createproject2').live('click', function() {
    var user = $('#login_user').val();
    var logout = $('#logOut').val();
    var create_url =  window.location.protocol + "//" + window.location.host + '/projects/manage';
    var href = $(this).attr('href');
    if (href.indexOf("tag=") != -1) {
      /* add tag to project url */
      tag = href.substring(href.indexOf("tag=") + 4);
    }
    if (logout === undefined) {
      $('a.signUp').trigger('click');
      $('#create_flag').attr('redirect', 'true');
      return false;
    }
  });

  var get_tags = function(formData, jqForm, options) {
    // grab ids of selected featured projects
    var ids = $("input:checkbox[name=featured]:checked").map(function()
    {
      return $(this).attr('id');
    }).get();
    // add to form
    formData.push({ name: 'featured', value: ids.join(',') });
  };

  $("#partnerDiv").submit(function() {
    var up_suc = function(responseText, statusText, xhr, form) {
      alert('Your page was successfully saved');
    };

    $(this).ajaxSubmit({
      beforeSubmit: get_tags,
      success: up_suc
    });
    // always return false to prevent standard browser submit and page
    // navigation
    return false;
  });

  $('.approveProject').click(function() {
    var projectId = $(this).attr('rel');
    var _this = $(this);
    $.ajax({
      type: 'POST',
      url: '/projects/approveTag',
      dataType: "json",
      data: {
        project_id: projectId,
        tag_id: $('#tag_id').val()
      }
    }).done(function(res) {
      _this.parents('tr').css('background', 'none');
      _this.parents('tr').css('border', 'none');
      _this.next().remove();
      _this.remove();
    });
    return false;
  });

  $('.denyProject').click(function() {
    var projectId = $(this).attr('rel');
    var _this = $(this);
    $.ajax({
      type: 'POST',
      url: '/projects/removeTags',
      dataType: "json",
      data: {
        ids: [projectId],
        tag_id: $('#tag_id').val()
      }
    }).done(function(res) {
      _this.parents('tr').remove();
    });
    return false;
  });

  /* send project owners a message */
  $('a#compose_message').click(function() {
    // get selected project creators
    var project_creators = {};
    var selected_projects = $("input:checkbox[name=creators]:checked").map(function()
    {
      var email = $(this).attr('email');
      // store in array to only get unique emails
      if (!project_creators[email]) {
        project_creators[email] = true;
        return email;
      }
    }).get();
   
    // separate by semicolon
    var emails = selected_projects.join(';');
    if (!emails) {
      alert("No projects selected.");
    }
    else {
      // open in new window
      window.open('mailto:' + emails);
    }
    return false;
  });

  $('a#deleteSelected').click(function() {
     var selected = $("input:checkbox[name=creators]:checked");
     var featured_selected = [];
     var ids = selected.map(function()
    {
        var featured = $(this).closest('tr').find('td input:checkbox[name=featured]:checked');
        if (featured.length > 0)
          featured_selected.push($(this).attr('project_id'));
        return $(this).attr('project_id');
    }).get();
    if (ids.length === 0)  {
      alert('No projects selected for removal');
      return false;
    }
    if (!confirm('Are you sure you want to delete these projects?')) {
      return false;
    }
    var base_url = window.location.protocol + "//" + window.location.host;
    if (featured_selected.length > 0) {
        $.post(base_url + '/partners/removeFeatured', 
          { ids: featured_selected, partner_id: $('input#partner_id').val() });
    }
    $.post(base_url + '/projects/removeTags', { ids: ids, tag_id: $(this).attr('tag_id') },
      function(data) {
        // remove trs selected projects belonged to
        selected.map(function()
        {
           $(this).closest('tr').remove();
        });
      }
    );
    return false;
  });

  $('button#publish').click(function() {
    var pub_bool = $(this).attr('value') ? 0 : 1;
    var partner_id = $('input#partner_id').val();
    var base_url = window.location.protocol + "//"+ window.location.host;
    $.post(base_url + '/partners/publish', { published: pub_bool, id: partner_id },
      function(data) {
        var pub_txt = pub_bool ? 'Unpublish' : 'Publish';
        $('button#publish').text(pub_txt);
        $('button#publish').attr('value', pub_bool ? "1" : "");
        Cufon.refresh();
        alert('Your page was successfully updated!');
      }
    );
    return false;
  });

  choose_state = function(country, state) {
    switch (country) {
      case 'United States':
        $('#state').addOption($('#country').getUsStates(), false); 
        $('#state option[value='+state+']').attr("selected", "selected");
        break;
      case 'Canada':
        $('#state').addOption($('#country').getCanStates(), false);
        $('#state option[value='+state+']').attr("selected", "selected");
        break;
      case 'United Kingdom':
        $('#state').addOption($('#country').getUkStates(), false); 
        $('#state option[value='+state+']').attr("selected", "selected");
        break;
      default:
        break;
    }
  };


 if ($.browser.msie && parseInt($.browser.version, 10) === 8) { 
   $('#upgrade').show();
 }

});
