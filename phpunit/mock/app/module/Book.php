<?php

namespace Foo;

class Book
{
    public function fetchRow (\Foo\Request $request)
    {
        return $request->requireParam('book_id');
    }
}
