import Ember from 'ember';

export default Ember.Route.extend({
    model(params){
        return this.store.findRecord('video', params.id);
    },
    actions: {
        edit(video){
            video.save().then(result=> {
                console.log(result);
                this.transitionTo('videos.video', video.get('id'));
            }).catch(error=> {
                console.log(error);
            });
            console.log('edit');
        }
    }
});
