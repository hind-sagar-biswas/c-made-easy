let menuHidden = true;

window.addEventListener("load", () => {
	if (screen.width < 500) {
        document.getElementById("menu").classList.add("hidden");
		document.getElementById("hamburger").addEventListener("click", () => {
            document.getElementById("menu").classList.toggle('hidden');
		});
	}
    document.getElementById('loader').classList.add('hidden');
});
