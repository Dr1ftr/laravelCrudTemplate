const rejectButtons = document.querySelectorAll(".button") as NodeListOf<HTMLButtonElement>;

// add event listener to each button
rejectButtons.forEach((button) => {
    button.addEventListener("click", () => {
        const accepted = confirm("Are you sure you want to reject this loan request?");

        if (!accepted) return;

        const form = button.parentElement as HTMLFormElement;

        form.submit();
    });
});
