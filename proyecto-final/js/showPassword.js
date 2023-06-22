export let renderShowPassword = () => {
    
    let ver = document.querySelector('.ver');
    let verRegister = document.querySelector('.ver-register');
    let verRegisterRepeat = document.querySelector('.ver-register-repeat');
    let verRegisterSell = document.querySelector('.ver-register-sell');
    let verRegisterRepeatSell = document.querySelector('.ver-register-repeat-sell');

    if (ver) {
        ver.addEventListener('click', () => {

            let input = document.querySelector('.contraseña');
    
            if (input.type == 'password') {
                input.type = 'text';
            } else {
                input.type = 'password';
            }
        });
    }

    if (verRegister) {

        verRegister.addEventListener('click', () => {

            let input = document.querySelector('.password-register');
    
            if (input.type == 'password') {
                input.type = 'text';
            } else {
                input.type = 'password';
            }
        });
    }

    if (verRegisterRepeat) {
                
            verRegisterRepeat.addEventListener('click', () => {
    
                let input = document.querySelector('.password-register-repeat');
        
                if (input.type == 'password') {
                    input.type = 'text';
                } else {
                    input.type = 'password';
                }
            });
        }
    
    if (verRegisterSell) {
                
        verRegisterSell.addEventListener('click', () => {
    
                let input = document.querySelector('.password-register-sell');
        
                if (input.type == 'password') {
                    input.type = 'text';
                } else {
                    input.type = 'password';
                }
            });
        }

    
    if (verRegisterRepeatSell) {
                
            verRegisterRepeatSell.addEventListener('click', () => {
    
                let input = document.querySelector('.password-register-repeat-sell');
        
                if (input.type == 'password') {
                    input.type = 'text';
                } else {
                    input.type = 'password';
                }
            });
        }   
}