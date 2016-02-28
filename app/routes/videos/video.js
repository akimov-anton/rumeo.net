import Ember from 'ember';

export default Ember.Route.extend({
    model(params){
        return this.store.findRecord('video', params.id);
    },
    actions: {
        edit(video){
            video.save().then(result=> {

            }).catch(error=> {

            });
            console.log('edit');
        }
    }
});
