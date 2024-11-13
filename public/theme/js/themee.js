var baseUrl;


$(function(){


	$('#whelminucbtn').click(function(){
		var bblance = parseInt($('#bblance').attr('data-coins'));
		var wheelplayvalue = parseInt($('#wheelplayvalue').val());
		if ( wheelplayvalue > 1 ) {
			var new_wheel_values = parseInt(wheelplayvalue) - 1;
			var new_wheel_playvalue_attrs = ( parseInt(bblance) + 1 ).toFixed(0);
			var new_wheel_playvalues = ( parseInt(bblance) + 1 ).toLocaleString('en-US');
			$('#bblance').attr('data-coins',new_wheel_playvalue_attrs);
			$('#balanceremin').text(new_wheel_playvalues);
			$('#wheelplayvalue').val(new_wheel_values);
		}
	});

	$('#whelplusbtn').click(function(){
		var bb_lance = parseInt($('#bblance').attr('data-coins'));
		var wheel_playvalue = parseInt($('#wheelplayvalue').val());
		let max = parseInt($('#wheelplayvalue').attr('max'));
		if ( wheel_playvalue > 0 && bb_lance > wheel_playvalue && wheel_playvalue < max) {
			var new_wheel_playvalue_attr = ( parseInt(bb_lance) - 1 ).toFixed(0);
			var new_wheel_playvalue = ( parseInt(bb_lance) - 1 ).toLocaleString('en-US');
			var new_wheel_value_s = parseInt(wheel_playvalue) + 1;
			$('#bblance').attr('data-coins',new_wheel_playvalue_attr);
			$('#balanceremin').text(new_wheel_playvalue);
			$('#wheelplayvalue').val(new_wheel_value_s);
		}
	});

	$('#searchHeaderForm').submit(function(){
		// if ( $('#searchHeaderForm #headerSearchQ').val() !== "" ) {
				return true;
		// }
		return false;
	});

	$('#submit').click(function(){
		$('#filters').submit();
	});
	
  // Sidebar toggle behavior
  $('#sidebarCollapse').on('click', function() {
    $('#sidebar, #content').toggleClass('active');
  });


	$('#homeCategorySlider').slick({
		slidesToShow: 6,
		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: 2000,
		infinite: true,
		arrows: true,
		nextArrow: '<button class="nextArrow"><i class="fa-solid fa-chevron-right"></i></button>',
		prevArrow: '<button class="prevArrow"><i class="fa-solid fa-chevron-left"></i></button>',
		responsive: [
	    {
	      breakpoint: 1081,
	      settings: {
	        centerMode: true,
	        centerPadding: '0px',
	        slidesToShow: 4
	      }
	    },
	    {
	      breakpoint: 845,
	      settings: {
	        centerMode: true,
	        centerPadding: '0px',
	        slidesToShow: 2
	      }
	    },
	    {
	      breakpoint: 577,
	      settings: {
	        centerMode: true,
	        centerPadding: '0px',
	        slidesToShow: 1
	      }
	    },
	    {
	      breakpoint: 481,
	      settings: {
	        centerMode: true,
	        centerPadding: '0px',
	        slidesToShow: 1
	      }
	    }
	  	]
	});

	$('#storesSlider').slick({
		slidesToShow: 7,
		slidesToScroll: 3,
		autoplay: true,
		autoplaySpeed: 2000,
		infinite: true,
		arrows: true,
		nextArrow: '<button class="nextArrow"><i class="fa-solid fa-chevron-right"></i></button>',
		prevArrow: '<button class="prevArrow"><i class="fa-solid fa-chevron-left"></i></button>',
		responsive: [
	    {
	      breakpoint: 1081,
	      settings: {
	        centerMode: true,
	        centerPadding: '0px',
	        slidesToShow: 7
	      }
	    },
	    {
	      breakpoint: 845,
	      settings: {
	        centerMode: true,
	        centerPadding: '0px',
	        slidesToShow: 5
	      }
	    },
	    {
	      breakpoint: 577,
	      settings: {
	        centerMode: true,
	        centerPadding: '0px',
	        slidesToShow: 3
	      }
	    },
	    {
	      breakpoint: 481,
	      settings: {
	        centerMode: true,
	        centerPadding: '0px',
	        slidesToShow: 3
	      }
	    }
	  	]
	});

	$('.testimonials').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		autoplay: false,
		autoplaySpeed: 2000,
		infinite: true,
		arrows: true,
		nextArrow: '<button class="nextArrow"><i class="fa-solid fa-chevron-right"></i></button>',
		prevArrow: '<button class="prevArrow"><i class="fa-solid fa-chevron-left"></i></button>',
		responsive: [
	    {
	      breakpoint: 1081,
	      settings: {
	        centerMode: true,
	        centerPadding: '0px',
	        slidesToShow: 4
	      }
	    },
	    {
	      breakpoint: 845,
	      settings: {
	        centerMode: true,
	        centerPadding: '0px',
	        slidesToShow: 2
	      }
	    },
	    {
	      breakpoint: 577,
	      settings: {
	        centerMode: true,
	        centerPadding: '0px',
	        slidesToShow: 1
	      }
	    },
	    {
	      breakpoint: 481,
	      settings: {
	        centerMode: true,
	        centerPadding: '0px',
	        slidesToShow: 1
	      }
	    }
	  	]
	});

	$('.related-slider').slick({
		slidesToShow: 4,
		slidesToScroll: 1,
		autoplay: false,
		autoplaySpeed: 2000,
		infinite: true,
		arrows: false,
		dots: true,
		nextArrow: '<button class="nextArrow"><i class="fa-solid fa-chevron-right"></i></button>',
		prevArrow: '<button class="prevArrow"><i class="fa-solid fa-chevron-left"></i></button>',
		responsive: [
	    {
	      breakpoint: 1081,
	      settings: {
	        centerMode: true,
	        centerPadding: '0px',
	        slidesToShow: 4
	      }
	    },
	    {
	      breakpoint: 845,
	      settings: {
	        centerMode: true,
	        centerPadding: '0px',
	        slidesToShow: 2
	      }
	    },
	    {
	      breakpoint: 577,
	      settings: {
	        centerMode: true,
	        centerPadding: '0px',
	        slidesToShow: 1
	      }
	    },
	    {
	      breakpoint: 481,
	      settings: {
	        centerMode: true,
	        centerPadding: '0px',
	        slidesToShow: 1
	      }
	    }
	  	]
	});

	$('.homepagesliderbanner').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: 5000,
		infinite: true,
		arrows: true,
		nextArrow: '<button class="slidernextArrow"><i class="fa-solid fa-chevron-right"></i></button>',
		prevArrow: '<button class="sliderprevArrow"><i class="fa-solid fa-chevron-left"></i></button>',
		responsive: [
	    {
	      breakpoint: 1081,
	      settings: {
	        centerMode: true,
	        centerPadding: '0px',
	        slidesToShow: 1
	      }
	    },
	    {
	      breakpoint: 845,
	      settings: {
	        centerMode: true,
	        centerPadding: '0px',
	        slidesToShow: 1
	      }
	    },
	    {
	      breakpoint: 577,
	      settings: {
	        centerMode: true,
	        centerPadding: '0px',
	        slidesToShow: 1
	      }
	    },
	    {
	      breakpoint: 481,
	      settings: {
	        centerMode: true,
	        centerPadding: '0px',
	        slidesToShow: 1
	      }
	    }
	  	]
	});

	$('.headersearchslider').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: 5000,
		infinite: true,
		arrows: true,
		nextArrow: '.searchnextArrow',
		prevArrow: '.searchprevArrow',
		responsive: [
	    {
	      breakpoint: 1081,
	      settings: {
	        centerMode: true,
	        centerPadding: '0px',
	        slidesToShow: 1
	      }
	    },
	    {
	      breakpoint: 845,
	      settings: {
	        centerMode: true,
	        centerPadding: '0px',
	        slidesToShow: 1
	      }
	    },
	    {
	      breakpoint: 577,
	      settings: {
	        centerMode: true,
	        centerPadding: '0px',
	        slidesToShow: 1
	      }
	    },
	    {
	      breakpoint: 481,
	      settings: {
	        centerMode: true,
	        centerPadding: '0px',
	        slidesToShow: 1
	      }
	    }
	  	]
	});

	$('.rtl-slider').slick({
	  slidesToShow: 1,
	  slidesToScroll: 1,
	  arrows: false,
	  fade: true,
	  asNavFor: '.rtl-slider-nav'
	});

	$('.rtl-slider-nav').slick({
		slidesToShow: 5,
		slidesToScroll: 1,
		vertical: true,
	   asNavFor: '.rtl-slider',
	   centerMode: false,
	   focusOnSelect: true,
	  arrows: true,
		prevArrow: ".thumb-prev",
   	nextArrow: ".thumb-next",
	});




 	$('#loginBtn').click(function(){
 		$('.loader').show();
 		var userEmail = $('#userEmail').val();
 		var userPassword = $('#userPassword').val();
 		var _user_login_token = $('#_tt_cc').val();
 		if ( userEmail == "" || userPassword == "" ) {
 			$('#nav-login .errorForm').html('<p class="position-absolute">Please fill all required fields ( * )</p>');
 			setTimeout(	function(){
 				$('#nav-login .errorForm p').remove()
 			}, 5000);
 			$('.loader').hide();
 		} else if ( ValidateEmail( userEmail ) == false ) {
 			// $('.errorForm').html('<p class="position-absolute">Please fill all required fields ( * )</p>');
 			setTimeout(	function(){
 				$('#nav-login .errorForm p').remove()
 			}, 5000);
 			$('.loader').hide();
 		} else {
 				$.ajaxSetup({
		        beforeSend: function(xhr) {
		            xhr.setRequestHeader('X-CSRF-TOKEN', _user_login_token);
		        }
		    });
	 			$.ajax({
		      url: baseUrl + "register/auth",
		      type:"POST",
		      data: { userEmail: userEmail, userPassword: userPassword },
		      dataType:"json",
		      success: function(resp){
		      	$('#_tt_cc').val(resp.token);
		      	if ( resp.code == 2 ) {
		      			$('#nav-login .successForm').html('<p class="position-absolute">Login Successfully</p>');
		      			setTimeout(	function(){
					 				$('.successForm p').remove();
					 				location.reload();
					 			}, 1000);
					 			$('.loader').hide();
		      	} else {
		      			$('#nav-login .errorForm').html('<p class="position-absolute">'+resp.msg+'</p>');
		      			setTimeout(	function(){
					 				$('#nav-login .errorForm p').remove()
					 			}, 5000);
					 			$('.loader').hide();
		      	}
		      }
		    });
 		}
 	});

 	$('#frindBtn').click(function(){
 		$('.loader').show();
 		var friendEmail = $('#friendEmail').val();
 		var friendMsg = $('#friendMsg').val();
 		var friendName = $('#friendName').val();
 		var _user_register_token = $('#_tt_cc').val();
 		if ( friendEmail == "" || friendMsg == "" || friendName == "" ) {
 			$('#showReferLogin .errorForm').html('<p class="position-absolute">Please fill all fields</p>');
 			setTimeout(	function(){
 				$('#showReferLogin .errorForm p').remove()
 			}, 5000);
 			$('.loader').hide();
 		} else if ( ValidateEmail( friendEmail ) == false ) {
 			$('#showReferLogin .errorForm p').html('<p class="position-absolute">Please enter valid email</p>');
 			setTimeout(	function(){
 				$('#showReferLogin .errorForm p').remove()
 			}, 5000);
 			$('.loader').hide();
 		} else {
 				$.ajaxSetup({
		        beforeSend: function(xhr) {
		            xhr.setRequestHeader('X-CSRF-TOKEN', _user_register_token);
		        }
		    });
	 			$.ajax({
		      url: baseUrl + "register/refer",
		      type:"POST",
		      data: { friendEmail: friendEmail, friendMsg: friendMsg , friendName: friendName },
		      dataType:"json",
		      success: function(resp){
		      	$('#_tt_cc').val(resp.token);
		      	if ( resp.code == 2 ) {
		      			$('#showReferLogin .successForm').html('<p class="position-absolute">'+resp.msg+'</p>');
		      			setTimeout(	function(){
					 				$('#showReferLogin .successForm p').remove();
					 				location.reload();
					 			}, 1000);
					 			$('.loader').hide();
		      	} else {
		      			$('#showReferLogin .errorForm').html('<p class="position-absolute">'+resp.msg+'</p>');
		      			setTimeout(	function(){
					 				$('#showReferLogin .errorForm p').remove()
					 			}, 5000);
					 			$('.loader').hide();
		      	}
		      }
		    });
 		}
 	});



 	$('#singupbtn').click(function(){
 		$('.loader').show();
 		var userSignEmail = $('#userSignEmail').val();
 		var userSignusername = $('#userSignusername').val();
 		var userSignPassword = $('#userSignPassword').val();
 		var _user_refer_token = $('#_user_refer_token').val();
 		var _user_register_token = $('#_tt_cc').val();
 		if ( userSignEmail == "" || userSignusername == "" || userSignPassword == "" ) {
 			$('#nav-signup .errorForm').html('<p class="position-absolute">Please fill all fields</p>');
 			setTimeout(	function(){
 				$('#nav-signup .errorForm p').remove()
 			}, 5000);
 			$('.loader').hide();
 		} else if ( ValidateEmail( userSignEmail ) == false ) {
 			// $('.errorForm').html('<p class="position-absolute">Please fill all required fields ( * )</p>');
 			setTimeout(	function(){
 				$('#nav-signup .errorForm p').remove()
 			}, 5000);
 			$('.loader').hide();
 		} else {
 				$.ajaxSetup({
		        beforeSend: function(xhr) {
		            xhr.setRequestHeader('X-CSRF-TOKEN', _user_register_token);
		        }
		    });
	 			$.ajax({
		      url: baseUrl + "register/add",
		      type:"POST",
		      data: { userSignEmail: userSignEmail, userSignusername: userSignusername , userSignPassword: userSignPassword , _user_refer_token: _user_refer_token },
		      dataType:"json",
		      success: function(resp){
		      	$('#_tt_cc').val(resp.token);
		      	if ( resp.code == 2 ) {
		      			$('#nav-signup .successForm').html('<p class="position-absolute">'+resp.msg+'</p>');
		      			setTimeout(	function(){
					 				$('#nav-signup .successForm p').remove();
					 				if ( _user_refer_token !== 0 ) {
					 						window.location.href = baseUrl;
					 				} else {
					 						location.reload();
					 				}
					 			}, 1000);
					 			$('.loader').hide();
		      	} else {
		      			$('#nav-signup .errorForm').html('<p class="position-absolute">'+resp.msg+'</p>');
		      			setTimeout(	function(){
					 				$('#nav-signup .errorForm p').remove()
					 			}, 5000);
					 			$('.loader').hide();
		      	}
		      }
		    });
 		}
 	});

 	$('#vRegisterBtn').click(function(){
 			var _vendor_token = $('#_vendor_token').val();
 			var vEmail = $('#vEmail').val();
	 		var vStoreName = $('#vStoreName').val();
	 		var vStoreLink = $('#vStoreLink').val();
	 		var vPassword = $('#vPassword').val();
	 		var vConfirmPassword = $('#vConfirmPassword').val();
	 		if ( vEmail == "" || vStoreName == "" || vPassword == "" || vConfirmPassword == "" ) {
	 			$('.errorForm').html('<p class="position-absolute">Please fill all fields ( * )</p>');
	 			setTimeout(	function(){
	 				$('.errorForm p').remove()
	 			}, 5000);
	 		} else if ( ValidateEmail( vEmail ) == false ) {
	 			setTimeout(	function(){
	 				$('.errorForm p').remove()
	 			}, 5000);
	 		}  else if ( vPassword !== vConfirmPassword ) {
	 			$('.errorForm').html('<p class="position-absolute">Password & Confirm Password is not equal</p>');
	 			setTimeout(	function(){
	 				$('.errorForm p').remove()
	 			}, 5000);
	 		} else {
	 			$.ajaxSetup({
		        beforeSend: function(xhr) {
		            xhr.setRequestHeader('X-CSRF-TOKEN', _vendor_token);
		        }
		    });
	 			$.ajax({
		      url: baseUrl + "vendor-add",
		      type:"POST",
		      data: { vEmail: vEmail, vStoreName: vStoreName, vStoreLink: vStoreLink, vPassword: vPassword, vConfirmPassword: vConfirmPassword },
		      dataType:"json",
		      success: function(resp){
		      	if ( resp.code == 2 ) {
		      			$('#vEmail').val('');
		      			$('#vStoreName').val('');
		      			$('#vStoreLink').val('');
		      			$('#vPassword').val('');
		      			$('#vConfirmPassword').val('');
		      			$('.successerror').html('<p class="successicon"><i class="fa-solid fa-circle-check"></i></p><p><b>'+resp.msg+'</b></p><p>We will update you shortly via email</p>');
		      			setTimeout(	function(){
					 				$('.successerror p').remove()
					 			}, 5000);
		      	} else {
		      			$('.errorForm').html('<p class="position-absolute">'+resp.msg+'</p>');
		      	}
		      	$('#_vendor_token').val(resp.token);
		      }
		    });

	 			// $('.successForm').html('<p class="position-absolute">Signup Successfully</p>');
	 			// setTimeout(	function(){
	 			// 	$('.successForm p').remove();
	 			// 	location.reload();
	 			// }, 3000);
	 		}
 	});

 	$('#vLoginBtn').click(function(){
 		$('.loader').show();
 		var userEmail = $('#vLoginEmail').val();
 		var userPassword = $('#vLoginPassword').val();
 		var _user_login_token = $('#_vendor_login_token').val();
 		if ( userEmail == "" || userPassword == "" ) {
 			$('.vLoginform .errorForm').html('<p class="position-absolute">Please fill all required fields ( * )</p>');
 			setTimeout(	function(){
 				$('.vLoginform .errorForm p').remove()
 			}, 5000);
 			$('.loader').hide();
 		} else if ( ValidateEmail( userEmail ) == false ) {
 			setTimeout(	function(){
 				$('.vLoginform .errorForm p').remove()
 			}, 5000);
 			$('.loader').hide();
 		} else {
 				$.ajaxSetup({
		        beforeSend: function(xhr) {
		            xhr.setRequestHeader('X-CSRF-TOKEN', _user_login_token);
		        }
		    });
	 			$.ajax({
		      url: baseUrl + "vendor-login-verify",
		      type:"POST",
		      data: { userEmail: userEmail, userPassword: userPassword },
		      dataType:"json",
		      success: function(resp){
		      	if ( resp.code == 2 ) {
		      			$('.vLoginform .successForm').html('<p class="position-absolute">Login Successfully</p>');
		      			setTimeout(	function(){
					 				$('.successForm p').remove();
					 				window.location.href = baseUrl+'vendors';
					 			}, 1000);
					 			$('.loader').hide();
		      	} else {
		      			$('.vLoginform .errorForm').html('<p class="position-absolute">'+resp.msg+'</p>');
		      			setTimeout(	function(){
					 				$('.vLoginform .errorForm p').remove()
					 			}, 5000);
					 			$('.loader').hide();
		      	}
		      	$('#_vendor_login_token').val(resp.token);
		      }
		    });
 		}
 	});

 	$('#dashUser').click(function(){
 			$('.loader').show();
 			var dashUserName = $('#dashUserName').val();
 			var _profileToken = $('#_profileToken').val();
 			if ( dashUserName == "" ) {
 					$('.errorBlock').html('<p class="alert alert-danger">Please enter your full name</p>');
 					setTimeout(function(){
 						$('.errorBlock p').remove();
 					}, 3000);
 					$('.loader').hide();
 			} else {
	 				$.ajaxSetup({
			        beforeSend: function(xhr) {
			            xhr.setRequestHeader('X-CSRF-TOKEN', _profileToken);
			        }
			    });
	 				$.ajax({
	 						url: baseUrl+'dashboard/account/update',
	 						type: 'POST',
	 						data : { 'dashUserName' : dashUserName, 'type': 1 },
	 						dataType: 'JSON',
	 						success: function(resp){
	 								$('#_profileToken').val(resp._cc);
	 								if ( resp.error == 2 ) {
	 										$('#fullnameUpdate').text(dashUserName);
	 										$('#userupdate').hide();
	 										$('#userfname').show();
						 					$('.errorBlock').html('<p class="alert alert-success">'+resp.msg+'</p>');
						 					setTimeout(function(){
						 						$('.errorBlock p').remove();
						 					}, 3000);
	 								} else {
						 					$('.errorBlock').html('<p class="alert alert-danger">'+resp.msg+'</p>');
						 					setTimeout(function(){
						 						$('.errorBlock p').remove();
						 					}, 3000);
	 								}
 									$('.loader').hide();
	 						}
	 				});
 			}
 	});

 	$('#dashEdit').click(function(){
			$('#userupdate').show();
			$('#userfname').hide();
 	})

 	$('#emailVerify').click(function(){
 			$('.loader').show();
 			var _profileToken = $('#_profileToken').val();
 			$.ajaxSetup({
	        beforeSend: function(xhr) {
	            xhr.setRequestHeader('X-CSRF-TOKEN', _profileToken);
	        }
	    });
			$.ajax({
					url: baseUrl+'dashboard/account/update',
					type: 'POST',
					data : { 'type': 2 },
					dataType: 'JSON',
					success: function(resp){
							// console.log(resp);
							$('#_profileToken').val(resp._cc);
							if ( resp.error == 2 ) {
				 					$('.errorBlock').html('<p class="alert alert-success">'+resp.msg+'</p>');
				 					setTimeout(function(){
				 						$('.errorBlock p').remove();
				 					}, 3000);
							} else {
									$('.errorBlock').html('<p class="alert alert-danger">There is some problem, please try again later</p>');
				 					setTimeout(function(){
				 						$('.errorBlock p').remove();
				 					}, 3000);
							}
							$('.loader').hide();
					}
			});
 	});

 	$('#emailVerify').click(function(){
 			$('.loader').show();
 			var _profileToken = $('#_profileToken').val();
 			$.ajaxSetup({
	        beforeSend: function(xhr) {
	            xhr.setRequestHeader('X-CSRF-TOKEN', _profileToken);
	        }
	    });
			$.ajax({
					url: baseUrl+'dashboard/account/update',
					type: 'POST',
					data : { 'type': 2 },
					dataType: 'JSON',
					success: function(resp){
							// console.log(resp);
							$('#_profileToken').val(resp._cc);
							if ( resp.error == 2 ) {
				 					$('.errorBlock').html('<p class="alert alert-success">'+resp.msg+'</p>');
				 					setTimeout(function(){
				 						$('.errorBlock p').remove();
				 					}, 3000);
							} else {
									$('.errorBlock').html('<p class="alert alert-danger">There is some problem, please try again later</p>');
				 					setTimeout(function(){
				 						$('.errorBlock p').remove();
				 					}, 3000);
							}
							$('.loader').hide();
					}
			});
 	});

 	$('#passwordEditUser').click(function(){
			$('#passwordUserBlock').toggle();
 	})

 	$('#userePasswordBtn').click(function(){
 			$('.loader').show();
 			var userePasswordInput = $('#userePasswordInput').val();
 			var _profileToken = $('#_profileToken').val();
 			if ( dashUserName == "" ) {
 					$('.errorBlock').html('<p class="alert alert-danger">Please enter your full name</p>');
 					setTimeout(function(){
 						$('.errorBlock p').remove();
 					}, 3000);
 					$('.loader').hide();
 			} else {
	 				$.ajaxSetup({
			        beforeSend: function(xhr) {
			            xhr.setRequestHeader('X-CSRF-TOKEN', _profileToken);
			        }
			    });
	 				$.ajax({
	 						url: baseUrl+'dashboard/account/update',
	 						type: 'POST',
	 						data : { 'userePasswordInput' : userePasswordInput, 'type': 3 },
	 						dataType: 'JSON',
	 						success: function(resp){
	 								$('#_profileToken').val(resp._cc);
	 								if ( resp.error == 2 ) {
	 										$('#passwordUserBlock').hide();
						 					$('.errorBlock').html('<p class="alert alert-success">'+resp.msg+'</p>');
						 					setTimeout(function(){
						 						$('.errorBlock p').remove();
						 					}, 3000);
	 								} else {
						 					$('.errorBlock').html('<p class="alert alert-danger">'+resp.msg+'</p>');
						 					setTimeout(function(){
						 						$('.errorBlock p').remove();
						 					}, 3000);
	 								}
 									$('.loader').hide();
	 						}
	 				});
 			}
 	});

 	$('#askQuestionBtn').click(function(){
 			$('.loader').show();
 			var pid = $('#pid').val();
 			var askQuestionDetail = $('#askQuestionDetail').val();
 			var _user_ask_question = $('#_user_ask_question').val();
 			if ( askQuestionDetail == "" ) {
 					$('#askQuestion .errorForm').html('<p class="alert alert-danger">Please enter your Message</p>');
 					setTimeout(function(){
 						$('#askQuestion .errorBlock p').remove();
 					}, 3000);
 					$('.loader').hide();
 			} else {
	 				$.ajaxSetup({
			        beforeSend: function(xhr) {
			            xhr.setRequestHeader('X-CSRF-TOKEN', _user_ask_question);
			        }
			    });
	 				$.ajax({
	 						url: baseUrl+'products/askquestion',
	 						type: 'POST',
	 						data : { 'askQuestionDetail' : askQuestionDetail, 'pid' : pid },
	 						dataType: 'JSON',
	 						success: function(resp){
	 								$('#askQuestion #_user_ask_question').val(resp.token);
	 								if ( resp.code == 2 ) {
						 					$('#askQuestion .errorForm').html('<p class="alert alert-success">'+resp.msg+'</p>');
						 					setTimeout(function(){
						 						$('#askQuestion .errorForm p').remove();
	 											$('#askQuestion').modal('hide');
						 					}, 3000);
	 								} else {
						 					$('#askQuestion .errorForm').html('<p class="alert alert-danger">'+resp.msg+'</p>');
						 					setTimeout(function(){
						 						$('#askQuestion .errorForm p').remove();
						 					}, 3000);
	 								}
 									$('.loader').hide();
	 						}
	 				});
 			}
 	});

 	$('#productCommentBtn').click(function(){
 			$('.loader').show();
 			var pid = $('#pid').val();
 			var produtRating = $('input[name=produtRating]').val();
 			var productComment = $('#productComment').val();
 			var _user_product_comments = $('#_user_product_comments').val();
 			if ( produtRating == "" || productComment == "" ) {
 					$('#productCom .errorForm').html('<p class="alert alert-danger">Please select rate and enter comment</p>');
 					setTimeout(function(){
 						$('#productCom .errorBlock p').remove();
 					}, 3000);
 					$('.loader').hide();
 			} else {
	 				$.ajaxSetup({
			        beforeSend: function(xhr) {
			            xhr.setRequestHeader('X-CSRF-TOKEN', _user_product_comments);
			        }
			    });
	 				$.ajax({
	 						url: baseUrl+'products/ratecomments',
	 						type: 'POST',
	 						data : { 'pid' : pid, 'produtRating' : produtRating, 'productComment' : productComment },
	 						dataType: 'JSON',
	 						success: function(resp){
	 								$('#_user_product_comments').val(resp.token);
	 								if ( resp.code == 2 ) {
						 					$('#productCom .errorForm').html('<p class="alert alert-success">'+resp.msg+'</p>');
						 					setTimeout(function(){
						 						$('#askQuestion .errorForm p').remove();
						 					}, 3000);
						 					location.reload();
	 								} else {
						 					$('#productCom .errorForm').html('<p class="alert alert-danger">'+resp.msg+'</p>');
						 					setTimeout(function(){
						 						$('#productCom .errorForm p').remove();
						 					}, 3000);
	 								}
 									$('.loader').hide();
	 						}
	 				});
 			}
 	});

 	$('#checkoutform').validate({
 			errorElement: "small",
      errorClass : 'text-danger',
 	});

});

function remove_param_from_url(url,param)
{

}

function showLogin(id)
{
		$('#accountModal .nav-link').removeClass('active');
		$('#accountModal .tab-pane').removeClass('show active');
		if ( id == 'login' ) {
				$('#accountModal #nav-login-tab').addClass('active');
				$('#accountModal #nav-login').addClass('show active');
				$('#accountModal').modal('show');
		} else {
				$('#accountModal #nav-signup-tab').addClass('active');
				$('#accountModal #nav-signup').addClass('show active');
				$('#accountModal').modal('show');
		}
}

function showReferLogin()
{
		$('#showReferLogin').modal('show');
}

function askQuestion()
{
		$('#askQuestion').modal('show');
}

function add_item_wish(dd,ss,id=0)
{
		$('.loader').show();
		$.ajaxSetup({
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', $('#_tt_cc').val());
        }
    });
		$.ajax({
				url: baseUrl+'wishlist/add',
				type: 'POST',
				data : { 'dd': dd, 'ss': ss },
				dataType: 'JSON',
				success: function(resp){
						console.log(resp);
						$('#_tt_cc').val(resp._cc);
						if ( resp.error == 2 ) {
								if ( id > 0 ) {
									$.notify(
									  ""+resp.msg+"", 
									  "success", 
									  { position:"right middle" }
									);
								}
			 					$('.errorBlock').html('<p class="alert alert-success">'+resp.msg+'</p>');
			 					setTimeout(function(){
			 						$('.errorBlock p').remove();
			 					}, 3000);
						} else if ( resp.error == 3 ) {
								if ( id > 0 ) {
									$.notify(
									  ""+resp.msg+"", 
									  { position:"right middle" }
									);
								}
								$('.errorBlock').html('<p class="alert alert-danger">There is some problem, please try again later</p>');
			 					setTimeout(function(){
			 						$('.errorBlock p').remove();
			 					}, 3000);
						}else {
								$('#accountModal').modal('show');
								$('.errorBlock').html('<p class="alert alert-danger">There is some problem, please try again later</p>');
			 					setTimeout(function(){
			 						$('.errorBlock p').remove();
			 					}, 3000);
						}
						$('.loader').hide();
				}
		});
}

function showPass(ids,passid)
{
		var vLoginPassword = $('#'+passid).attr('type');
		if ( vLoginPassword == 'password' ) {
				$('#'+ids+' .fa-solid').removeClass('fa-eye-slash');
				$('#'+ids+' .fa-solid').addClass('fa-eye');
				$('#'+passid).attr('type','text');
		} else {
				$('#'+ids+' .fa-solid').removeClass('fa-eye');
				$('#'+ids+' .fa-solid').addClass('fa-eye-slash');
				$('#'+passid).attr('type','password');
		}
}

function ValidateEmail(mail) 
{
	var mailformat = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
 if (mail.match(mailformat))
  {
    return (true)
  }
  	$('.errorForm').html('<p class="position-absolute">You have entered an invalid email address!</p>');
    return (false)
}

function scrollEmailForm()
{
	$('html, body').animate({
        scrollTop: $("#sliderEmail").offset().top -500
    }, 500);
    // $( "#sliderEmail input.subscribeemail" ).focus();
}


function email_subscribe(subscribeemail,emailerror)
{
	$('.lds-grid').show();
	var se = $('.'+subscribeemail).val();

	// CSRF Hash
       var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
       var csrfHash = $('.txt_csrfname').val(); // CSRF hash
	$.ajax({
		url: baseUrl+'mailchimps',
		type: 'POST',
		datatype:'JSON',
		data: { 'subscribeemail': se, [csrfName]: csrfHash },
		success: function(resp){
			var r = JSON.parse(resp);
			if ( r.code == 1 ) {
				$('.'+emailerror).html('<p class="alert alert-danger">'+r.detail+'</p>');
				$('.lds-grid').hide();
			} else {
				$('.'+emailerror).html('<p class="alert alert-success">'+r.detail+'</p>');
				$('.'+subscribeemail).val('');
				$('.lds-grid').hide();
			}
			$('.txt_csrfname').val(r.token);
			setTimeout(function(){
				$('.' + emailerror + ' p').remove();
			}, 5000);
		}
	});
}
 	


var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})