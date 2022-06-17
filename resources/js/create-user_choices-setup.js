const Choices = require('choices.js');

// get previously selected choices
let chosen = (document.previously_selected_user_roles ?? [])
    .map(str => parseInt(str)); // convert to ints

let choices = document.user_roles.map((choice) => {
    return {
        selected: chosen.includes(choice.id), // set selected based whether it's in chosen
        ...choice // add previous choice data
    }
});

// create choice.js object
const choice = new Choices('#role-choices', {
    choices: choices,

    // with options
    removeItemButton: true,
    allowHTML: false,
    searchFields: ['label']
});




// get previously selected academy
let chosen_academy = (parseInt(document.previously_selected_academy) ?? null);

let academies = document.academies.map((academy) => {
    return {
        selected: (chosen_academy === academy.id), // set selected based whether it's chosen
        ...academy
    }
});

// add a optional value, so that the user can select none
academies.push({
    selected: (chosen_academy == null || chosen_academy == -1 || isNaN(chosen_academy)),
    id: -1,
    value: -1,
    label: 'None'
});

console.log(academies, chosen_academy);

// create choice.js object
const academyChoice = new Choices('#academy-choices', {
    choices: academies,

    // with options
    allowHTML: false,
    searchFields: ['label'],
    maxItemCount: 1
});
