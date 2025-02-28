export function toggleButtonState(button, isDisabled) {
    button.disabled = isDisabled;
    button.classList.toggle("text-gray-400", isDisabled);
    button.classList.toggle("text-lightMode-blueHighlight", isDisabled);
}