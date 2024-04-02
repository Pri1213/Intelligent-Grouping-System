
const setStep = step => {
	document.querySelectorAll(".step-content").forEach(element => element.style.display = "none");
	document.querySelector("[data-step='" + step + "']").style.display = "block";
	document.querySelectorAll(".steps .step").forEach((element, index) => {
		index < step-1 ? element.classList.add("complete") : element.classList.remove("complete");
		index == step-1 ? element.classList.add("current") : element.classList.remove("current");
	});
};
document.querySelectorAll("[data-set-step]").forEach(element => {
	element.onclick = event => {
		event.preventDefault();
		setStep(parseInt(element.dataset.setStep));
	};
});
