
/**
 * @class app.loginization
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
		
		$("body").on("submit", "#site-login", function(e){
			var login = $("#login"),
				pass = $("#login-pass");
			$("input").removeClass("error");
			if(login.val().length < loginInputMinLength) {
				e.preventDefault();
				login.addClass("error");
				alert("Введіть правильний логін!");
				login.focus();
			} else if (pass.val().length < loginInputMinLength) {
				e.preventDefault();
				pass.addClass("error");
				alert("Введіть правильний пароль!");
				pass.focus();
			}
			
			
		});
	}
	/******* app.registry public object ********/
	app.loginization = {
		init : function () {
			initializeCache();
		//	initializeDom();
			initializeEvents();
		}

	};

}(window.app = window.app || {}, jQuery));

$( document ).ready(function() {
	app.loginization.init();
});