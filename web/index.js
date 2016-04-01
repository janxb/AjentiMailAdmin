var Credentials = function (email, password) {
    this.email = email;
    this.password = password;
}

var App = function () {
    var self = this;
    self.email = ko.observable("");
    self.password = ko.observable("");
    self.authenticated = ko.observable(false);
    self.loading = ko.observable(false);
    self.forwardersEnabled = ko.observable(false);
    self.forwarders = ko.observableArray([]);
    self.lang = ko.observable();

    self.newpass1 = ko.observable("");
    self.newpass2 = ko.observable("");
    self.newforwarder = ko.observable("");

    self._init = function () {
        var credentials = Cookies.getJSON("credentials");
        if (credentials !== undefined) {
            self.email(credentials.email);
            self.password(credentials.password);
            self._login();
        }
    }

    self._logout = function () {
        Cookies.remove("credentials");
        location.reload();
    }

    self._login = function () {
        request(
            "api/authenticate.php",
            {
                email: self.email(),
                auth: self.password()
            },
            function (data) {
                if (data.error === null) {
                    self.authenticated(true);
                    Cookies.set("credentials", new Credentials(self.email(), self.password()), {expires: 365});
                    self._fetchForwarders();
                } else {
                    alert(self.lang().loginfailed);
                }
            });
    };

    self._fetchForwarders = function () {
        request(
            "api/get_forwarders.php",
            {
                email: self.email(),
                auth: self.password()
            },
            function (data) {
                if (data.error === null) {
                    self.forwardersEnabled(true);
                    self.forwarders(data.data);
                } else {
                    self.forwarders.removeAll();
                    self.forwardersEnabled(false);
                }
            });
    }

    self._changePassword = function () {
        if (self.newpass1() !== self.newpass2()) {
            alert(self.lang().passwordsmustmatch);
            return;
        }

        request(
            "api/change_password.php",
            {
                email: self.email(),
                auth: self.password(),
                password: self.newpass1()
            },
            function (data) {
                if (data.error === null) {
                    alert(self.lang().passwordischanged);
                    self.password(self.newpass1());
                    self.newpass1("");
                    self.newpass2("");
                } else {
                    alert(self.lang().passwordchangefailed);
                }
            });
    }

    self._deleteForwarder = function (forwarder) {
        request(
            "api/remove_forwarder.php",
            {
                email: self.email(),
                auth: self.password(),
                forward: forwarder
            },
            function (data) {
                self._fetchForwarders();
            });
    }

    self._addForwarder = function () {
        var emailValid = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(self.newforwarder());


        if (!emailValid) {
            alert(self.lang().emailnotvalid);
            return;
        }

        request(
            "api/add_forwarder.php",
            {
                email: self.email(),
                auth: self.password(),
                forward: self.newforwarder()
            },
            function (data) {
                self._fetchForwarders();
                self.newforwarder("");
            });
    }

    var request = function (url, data, responseMethod) {
        $.post(url, data, function (data) {
            data = $.parseJSON(data);
            responseMethod(data);
        });
    }
};

var app = new App();
app._init();
app.lang(Translations.german);
ko.applyBindings(app);
