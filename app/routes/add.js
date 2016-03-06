import Ember from 'ember';

export default Ember.Route.extend({
    //model(){
    //  return this.store.createRecord('video')
    //},
    actions: {
        add(content){
            var video = this.store.createRecord('video');
            video.set('content', content);
            video.save().then(video=> {
                this.transitionTo('videos.video', video.get('id'));
            });
        }
    }
});
