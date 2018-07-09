use strict;
use warnings;

use Data::Dumper;


=pod
 
=head1 DESCRIPTION
 
This subroutine must have 1 parameter:
The complex structure, e.g. array, hash, number.
It will increment by 1 every item of the structure (recursively).
 
=cut

sub addtwo {
    
    my $s = shift;
    
    # check if args is simple array
    if ( ref( $s ) eq "ARRAY" ) {
        my $c = 0;
        for my $e (@$s) {
            $s->[$c] = addtwo( $e );
            $c++;
        }
    
    # check if args is hash (i.e. associative array)
    } elsif ( ref( $s ) eq "HASH" ) {
        foreach my $e (keys %{$s}) {
            $s->{$e} = addtwo( $s->{$e} );
        }
    
    # here we assume args is numeric (integer) - increment by 1
    } else {
        $s++;
    }
    
    return $s;
    
}

print Dumper( addtwo( [ { a => 1, b => 2, c => 3  }, { d => 4, e => 5 }, [ 6, 7, 8 ], 9, 10, 11, [ 12, 13, 14 ] ] ) );
