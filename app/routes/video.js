import Ember from 'ember';

export default Ember.Route.extend({
    model(params){
        var video = this.store.findRecord('video', params.id);
        return {
            video: video,
            categories: this.store.peekAll('video-category')
        }
    },
    actions: {
        edit(video_id){
            var video = this.store.peekRecord('video', video_id);
            var hash = video.get('youtubeId');
            if(hash){
                video.set('youtubeHash', hash);
            }
            video.save().then(result=> {
                console.log(result);
                this.transitionTo('video', video.get('id'));
            }).catch(error=> {
                console.log(error);
            });
            console.log('edit');
        }
    },
});
