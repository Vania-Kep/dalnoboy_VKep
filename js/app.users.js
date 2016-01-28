
/**
 * @class app.users
 */
(function (app, $) {
	var $cache = {};
	/**
	 * @private
	 * @function
	 * @description Cache initialization of the site login page
	 */
	function initializeCache() {}
	
	function initializeEvents() {

	//---------------------------------------------------------------------REGISTER
		var loginInputMinLength = 3;
		// register new user
		$("body").on("submit", "#site-register", function(e) {
			var newUserName = $("#new-user"),
				newUserPass = $("#new-user-pass"),
				newUserRePass = $("#new-user-re-pass"),
				newUserPermissions = $("#new-user-permissions");

			var newUserRegisterData = [newUserName, newUserPass, newUserRePass, newUserPermissions],
				errorMessage = "";

			$("#site-register input, #site-register select").removeClass("error");
			$(this).find(".form-error").html(errorMessage).hide();

			if( $.trim(newUserName.val()) == "" || $.trim(newUserPass.val()) == "" || $.trim(newUserRePass.val()) == "" || $.trim(newUserPermissions.val()) == "") {
				e.preventDefault();
				errorMessage = "Введіть всі дані!";
				$(this).find(".form-error").html(errorMessage).show();
			//	alert("Введіть всі дані!");
				for (var i = (newUserRegisterData.length-1); i >= 0; i--) {
					if ( $.trim(newUserRegisterData[i].val()) == "" ) {
						newUserRegisterData[i].addClass("error");
						newUserRegisterData[i].focus();
					}
				}
			} else if (newUserPass.val() != newUserRePass.val()) {
				e.preventDefault();
				newUserPass.addClass("error");
				newUserRePass.addClass("error");
				errorMessage = "Паролі не співпадають!";
				$(this).find(".form-error").html(errorMessage).show();
			//	alert("Паролі не співпадають!");
				newUserPass.focus();
			}
			
			
		});
		$("#site-register").on("blur", ".form-control.error", function(){
			var $this = $(this);
			if ($.trim($this.val()) != "") $this.removeClass("error");
		})
		function createDialog(title, text) {
	    return $("<div class='dialog' title='" + title + "'><p>" + text + "</p></div>")
	    .dialog({
	        resizable: false,
	        height:'auto',
	        modal: true,
			dialogClass : 'user-menagment-dlg',
	        buttons: {
	            "Confirm": function() {
					$("#show-users").off("click", "#remove");
	            	$( "#remove" ).trigger( "click" );
	                $( this ).dialog( "close" );
	            },
	            Cancel: function() {
	                $( this ).dialog( "close" );
	            }
	        },

			closeText :"X"
	    });
		}
	//--------------------------------------------------------------------------REMOVE USER
		//remove selected user
		$("#show-users").on("click", "#remove", function(e){
			e.preventDefault();
			var errorMessage = "";
			$("form#show-users .form-error").html(errorMessage).hide();
			var uid = getSelectedUserUID();
			if (uid == "") {
				errorMessage = "Виберіть користувача для видалення!";
				$("form#show-users .form-error").html(errorMessage).show();
				//alert("Виберіть користувача для видалення");
			} else {
				createDialog('Confirm deletion!', 'Do you really want to delete this user?');
			}
		});

		//get selected user id
		function getSelectedUserUID () {
			var selectedUser = $("#show-users input[type='radio']:checked");
			if (selectedUser.length) {
				var selectedUserUID = selectedUser.val().replace(/\D/g, '');
				return selectedUserUID;
			}
			return "";
		}

	  function createDialog(title, text) {
	    return $("<div class='dialog' title='" + title + "'><p>" + text + "</p></div>")
	    .dialog({
	        resizable: false,
	        height:'auto',
	        modal: true,
			dialogClass : 'user-menagment-dlg',
	        buttons: {
	            "Confirm": function() {
					$("#show-users").off("click", "#remove");
	            	$( "#remove" ).trigger( "click" );
	                $( this ).dialog( "close" );
	            },
	            Cancel: function() {
	                $( this ).dialog( "close" );
	            }
	        },

			closeText :"X"
	    });
}

	}
	/******* app.users public object ********/
	app.users = {
		init : function () {
			initializeCache();
		//	initializeDom();
			initializeEvents();
		}

	};

}(window.app = window.app || {}, jQuery));

$( document ).ready(function() {
	app.users.init();
});