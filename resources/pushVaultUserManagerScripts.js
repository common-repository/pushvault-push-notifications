function pauseResume(){
        if(document.getElementById("pushes-checkbox").checked == true){
                PushVault.resume(function(response) {
                        document.getElementById("pvlt-status").innerHTML = 'Allowed';
                        document.getElementById("pvlt-status").style.color = 'green';
                        console.log(response)
                })
        }else{
                PushVault.pause(function(response) {
                        document.getElementById("pvlt-status").innerHTML = 'Disallowed';
                        document.getElementById("pvlt-status").style.color = 'red';
                        console.log(response)
                })
        }
}
if(PushVault.isCompleted()){
        document.getElementById("pushes-checkbox").checked = 'true';
        document.getElementById("pvlt-status").innerHTML = 'Allowed';
        document.getElementById("pvlt-status").style.color = 'green';
}
