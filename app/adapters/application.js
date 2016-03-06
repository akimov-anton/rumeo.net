import DS from 'ember-data';

export default DS.JSONAPIAdapter.extend({
    host: 'http://rumeo.net/api.php',
    shouldReloadRecord(store, snapshot){
        return true;
    },

    shouldReloadAll(){
        return true;
    }
});
