# VSK (virtualbox-send-keys)
command line tool to send keys to virtualbox virtual machines through the keyboardputscancode interface by converting ascii codes to atx1 scan codes. This tool does not require the virtualbox guest additions to be installed and is a great way to automate initial build tasks.


## Requirements
php 5.6+

oracle virtualbox


## Usage example
    
    ====================================================
     ./vsk Help
     -v        Name of the vm to send to
     -s    quoted string to send to vm
     
     Available control characters:
     ^RETURN \n ^TAB \t
     
     Example: (login and download a file)
     ./vsk -v="myVM" -s='root\nmypass\n'
     ./vsk -v="myVM" -s='wget http://www.somedomain.com/myfile.tar.gz\n'

    
    
    

##Demo
[![IMAGE ALT TEXT](http://img.youtube.com/vi/VJCcVkh_oOo/0.jpg)](http://www.youtube.com/watch?v=VJCcVkh_oOo "vsk demo")




