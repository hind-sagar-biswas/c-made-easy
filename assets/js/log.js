const form = document.getElementById("log-form");
const submitBtn = document.getElementById("logger-type");
let inputTimeout;

function setValidity(input, validity) {
    submitBtn.disabled = !validity[0];
    if (!validity[0]) {
        document.querySelector(
            `label[for='${input.id}'] .red`
        ).textContent = `[ ${validity[1]} ]`;
        input.classList.add("invalid");
        input.classList.remove("valid");
    } else {
        document.querySelector(`label[for='${input.id}'] .red`).textContent =
            "";
        input.classList.add("valid");
        input.classList.remove("invalid");
    }
}

function checkTaken(input) {
    let checkValue = `${input.id}=${encodeURIComponent(input.value)}`;
    const xhttp = new XMLHttpRequest();
	xhttp.onload = function () {
		const res = JSON.parse(this.responseText);
        setValidity(input, [!res, `${input.id} already taken`]);
	};
	xhttp.open("POST", "./scripts/api/logger.api.php");
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(`type=check_taken&${checkValue}`);
}

function validateInput(input) {
	const type = input.type;
	const value = input.value;

    if (censor.check(value)) return setValidity(input, [false, "please do not use any bad words"]);

	switch (type) {
		case "text":
            if (input.id != 'username') return setValidity(input, [true]);
            const notAllowed = [" ", "\"", "\'", "@", "#", "%", "&", "-", "(", ")", "!"];
            for (let i = 0; i < notAllowed.length; i++) {
                if (input.value.includes(notAllowed[i])) return setValidity(input, [false, `only underscores(_) are allowed as special character.'`]);
            }
            checkTaken(input);
            break;
		case "password":
            if (input.id == 're-password' && document.getElementById('password').value != value) return setValidity(input, [false, 'does not match with above password']);
			if (value.length < 8 || value.length > 32) return setValidity(input, [false, 'length must be 8-32 characters']);
			if (!/[A-Z]/.test(value)) return setValidity(input, [false, 'must contain at least one uppercase letter']);
			if (!/[a-z]/.test(value)) return setValidity(input, [false, 'must contain at least one lowercase letter']);
			if (!/\d/.test(value)) return setValidity(input, [false, 'must contain at least one number']);
            return setValidity(input, [true]);
		case "email":
            if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value)) setValidity(input, [false, "invalid email address"]);
            checkTaken(input);
            break
		default:
			break;
	}
}

if ( form != null && submitBtn.value == "register" ) {
	form.addEventListener("input", (e) => {
        clearTimeout(inputTimeout);
        inputTimeout = setTimeout(() => {
            const element = e.target;
            validateInput(element);
        }, 1000);
	});
	// form.addEventListener("submit", (e) => {
    //     clearTimeout(inputTimeout);
    //     inputTimeout = setTimeout(() => {
    //         const element = e.target;
    //         validateInput(element);
    //     }, 1000);
	// });
}
