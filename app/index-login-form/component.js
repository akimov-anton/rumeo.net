import Ember from 'ember';

export default Ember.Component.extend({
    reg_mode: false,
    login: 'login',
    actions: {
        changeMode(){
            this.toggleProperty('reg_mode');
        },
        login(){
            this.sendAction('login', this.get('user'));
        }
    }
});
