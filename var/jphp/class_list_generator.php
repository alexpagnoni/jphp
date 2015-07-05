<?php

if ( $fh = fopen( 'prot', 'r' ) )
{
    while ( !feof( $fh ) )
    {
        $buf = trim( fgets( $fh, 4096 ) );
        if ( strlen( $buf ) )
        {
            echo "    <jphpclass\n        name=\"".$buf."\"\n        file=\"".$buf."\"/>\n";
        }
    }

    fclose( $fh );
}

?>