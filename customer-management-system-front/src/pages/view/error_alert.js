export function errorAlert(errors)
{
    let error_messages = "";
    errors.forEach(error => {
        error_messages += error.error_message + "\n";
    });
    alert(error_messages);
}