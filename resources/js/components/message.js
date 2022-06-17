// get all messages in .messaged-holder
const Messages = document.querySelectorAll('.messages-holder > div.message-div');

// for each message
Messages.forEach(message => {
    const Button = message.querySelector('button.message-close-button');

    // setup up the click functionality of the close button
    Button.addEventListener('click', () => {
        message.classList.add('hidden');
    });
});
