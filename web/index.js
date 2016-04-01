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

var english = {
    login: "Login",
    loginfailed: "Can't log in. Maybe you entered the wrong login data?",
    forwarders: "Forwarding adresses",
    forwardersdisabled: "Mail forwarding is not enabled for your account. Please contact your mail administrator.",
    changepassword: "Change mailbox password",
    delete: "Delete",
    logintext: "Please enter your email account login details.",
    email: "Email address",
    password: "Password",
    newpass1: "New password",
    newpass2: "Repeat new password",
    save: "Save",
    passwordsmustmatch: "The entered passwords are not the same. Please try again..",
    passwordischanged: "Your password has been changed.",
    passwordchangefailed: "Can't change your password. Maybe try again later?",
    emailnotvalid: "The entered email address is not valid!",
    logout: "Logout",
    headline:"Email Account Management for adress "
}

var german = {
    login: "Login",
    loginfailed: "Anmeldung fehlgeschlagen. Sind die Anmeldedaten korrekt?",
    forwarders: "Email Weiterleitungen",
    forwardersdisabled: "Email Weiterleitungen sind für den Account nicht aktiviert. Bitte an den Email Administrator wenden.",
    changepassword: "Account-Passwort ändern",
    delete: "Löschen",
    logintext: "Account Login-Daten eingeben.",
    email: "Email-Adresse",
    password: "Passwort",
    newpass1: "Neues Passwort",
    newpass2: "Passwort wiederholen",
    save: "Speichern",
    passwordsmustmatch: "Die beiden Passwörter sind nicht identisch. Bitte erneut versuchen..",
    passwordischanged: "Das Passwort wurde geändert.",
    passwordchangefailed: "Passwort konnte nicht geändert werden. Bitte später erneut versuchen..",
    emailnotvalid: "Die eingegebene Email-Adresse existiert nicht.",
    logout: "Abmelden",
    headline:"Email Account-Verwaltung von "
}

var greek = {
    login: "Σύνδεση",
    loginfailed: "Αδυναμία σύνδεσης. Μήπως έχετε δώσει λάθος στοιχεία;",
    forwarders: "Διευθύνσεις Προώθησης",
    forwardersdisabled: "Η προώθηση των email δεν είναι ενεργοποιημένη. Επικοινωνήστε με τον διαχειριστή.",
    changepassword: "Αλλαγή κωδικού",
    delete: "Διαγραφή",
    logintext: "Πληκτρολογήστε τα στοιχεία σύνδεσης του email σας",
    email: "Διεύθυνση Email",
    password: "Κωδικός",
    newpass1: "Νέος Κωδικός",
    newpass2: "Επανάληψη Νέου Κωδικού",
    save: "Αποθήκευση",
    passwordsmustmatch: "Οι κωδικοί δεν είναι ίδιοι. Προσπαθήστε ξανά...",
    passwordischanged: "Ο κωδικός σας έχει τροποποιηθεί.",
    passwordchangefailed: "Αδυναμία αλλαγής του κωδικού. Θέλετε να δοκιμάστε αργότερα;",
    emailnotvalid: "Δεν είναι σωστός ο κωδικός που πληκτρολογήσατε!",
    logout: "Αποσύνδεση",
    headline:"Διαχείριση Email για την διεύθυνση "
}

var app = new App();
app._init();
app.lang(german);
ko.applyBindings(app);
