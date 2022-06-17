const acceptButtons = document.querySelectorAll(".button2") as NodeListOf<HTMLButtonElement>;

// add event listener to each button
acceptButtons.forEach((button) => {
    button.addEventListener("click", () => {
        const accepted = confirm("Are you sure you want to accept this loan request?");

        if (!accepted) return;

        const form = button.parentElement as HTMLFormElement;

        form.submit();
    });
});
