<?php

//display success message
if (FlashMessage::has('success')) {
    echo FlashMessage::display('success');
}

//display error message
if (FlashMessage::has('error')) {
    echo FlashMessage::display('error');
}
