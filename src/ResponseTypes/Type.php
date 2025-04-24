<?php

namespace Basic\ResponseTypes;

enum Type: string
{
    case HTML = 'text/html';
    case JSON = 'application/json';
}
