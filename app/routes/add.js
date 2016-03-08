import Ember from 'ember';

export default Ember.Route.extend({
    model(params, transition){
        var category = transition.queryParams.category;

        return {
            category: this.store.peekRecord('video-category', category),
            categories: this.store.peekAll('video-category')
        }
    },
    actions: {
        add(source){
            var video = this.store.createRecord('video');
            video.set('source', source);
            //console.log(this.modelFor('add').category);
            //return;
            if(this.modelFor('add').category){
                var category = this.store.peekRecord('video-category', this.modelFor('add').category.get('id'));
                video.set('category', category);
            }
            video.save().then(video=> {
                this.transitionTo('video', video.get('id'));
            });
        }
    }
});
