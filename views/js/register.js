function submit(obj) {
    var user = obj.find("input[type=username]").val();
    var pass = obj.find("input[type=password]").val();
    var roleid = obj.find("select#UserRole option:selected").val();
	if(user =="" ||pass =="" ||roleid ==""){
		alert("Please enter all values!")
	}else{
		load("registerUser", {
			user,
			pass,
			roleid
		}, function(msg) {
			  $(location).attr('href', 'index.php?view=login');
		});
	}
}
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();