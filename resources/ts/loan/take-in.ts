const takeinButtons = document.querySelectorAll(".button2") as NodeListOf<HTMLButtonElement>;

// add event listener to each button
takeinButtons.forEach((button) => {
    button.addEventListener("click", () => {
        const accepted = confirm("Are you sure you want to take in this loan?");

        if (!accepted) return;

        const form = button.parentElement as HTMLFormElement;

        form.submit();
    });
});
