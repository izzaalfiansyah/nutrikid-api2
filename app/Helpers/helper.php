<?php
function apiAuth()
{
    return auth()->guard('api');
}
