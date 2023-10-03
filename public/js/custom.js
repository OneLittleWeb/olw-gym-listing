function handleIsClosedChange() {
    let isClosedCheckbox = document.getElementById("is_it_closed");
    let temporarilyClosedCheckbox = document.getElementById("temporarily_closed");

    temporarilyClosedCheckbox.disabled = !!isClosedCheckbox.checked;
}

function handleTemporarilyClosedChange() {
    let isClosedCheckbox = document.getElementById("is_it_closed");
    let temporarilyClosedCheckbox = document.getElementById("temporarily_closed");

    isClosedCheckbox.disabled = !!temporarilyClosedCheckbox.checked;
}
