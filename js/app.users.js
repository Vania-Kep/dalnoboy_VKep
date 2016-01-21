
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
		var loginInputMinLength = 3;
		
		$("body").on("submit", "#site-register", function(e) {
			var newUserName = $("#new-user"),
				newUserPass = $("#new-user-pass"),
				newUserRePass = $("#new-user-re-pass"),
				newUserPermissions = $("#new-user-permissions");

			var newUserRegisterData = [newUserName, newUserPass, newUserRePass, newUserPermissions];

			$("#site-register input, #site-register select").removeClass("error");
			if( $.trim(newUserName.val()) == "" || $.trim(newUserPass.val()) == "" || $.trim(newUserRePass.val()) == "" || $.trim(newUserPermissions.val()) == "") {
				e.preventDefault();
				alert("Введіть всі дані!");
				for (var i = (newUserRegisterData.length-1); i >= 0; i--) {
					if ( $.trim(newUserRegisterData[i].val()) == "" ) {
						newUserRegisterData[i].addClass("error");
						newUserRegisterData[i].focus();
					}
				}
			} else if (newUserPass != newUserRePass) {
				e.preventDefault();
				newUserPass.addClass("error");
				newUserRePass.addClass("error");
				alert("Паролі не співпадають!");
				newUserPass.focus();
			}
			
			
		});
		
		$("#show-users").on("click", "#remove", function(e) {
			var uid = getSelectedUserUID();
			if (uid == "") {
				e.preventDefault();
				alert("Виберіть користувача для видалення");
			}
			alert(uid);

		});

		function getSelectedUserUID () {
			var selectedUser = $("#show-users input[type='radio']:checked");
			if (selectedUser.length) {
				var selectedUserUID = selectedUser.val().replace(/\D/g, '');
				return selectedUserUID;
			}
			return "";
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