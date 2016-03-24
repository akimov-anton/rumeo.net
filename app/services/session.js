import Ember from 'ember';

export default Ember.Service.extend({
    store: Ember.inject.service(),
    localStorage: window.localStorage,
    //init(){
    //    this._super(...arguments);
    //    this.set('hash', window.localStorage.getItem('hash'));
    //},
    hash: '',
    uid: '',
    getItem(key){
        return this.get('localStorage').getItem(key);
    },
    setItem(key, value){
        return this.get('localStorage').setItem(key, value);
    },
    removeItem(key){
        this.get('localStorage').removeItem(key);
    },
    getUser(){
        var uid = this.getItem('user_id');
        if (!uid)
            return false;
        //this.set('user', this.get('store').findRecord('user', uid));

        if (this.get('store').hasRecordForId('user', uid)) {
            var user = this.get('store').peekRecord('user', uid);
            this.set('user', user);
            return user;
        }
        else {
            this.get('store').findRecord('user', uid).then(user=> {
                this.set('user', user);
            });
        }
    },
    login(user){
        this.set('user', user);
        this.setItem('user_id', user.get('id'));
        this.setItem('user_role', user.get('role'));
    },
    logout(){
        this.set('user', '');
        this.removeItem('_hash');
        this.removeItem('user_id');
        this.removeItem('user_role');
    }
});