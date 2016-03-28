import Ember from 'ember';

export default Ember.Route.extend({
    model(params){
        var video = this.store.findRecord('video', params.id);
        return Ember.RSVP.hash({
            video: video,
            categories: this.store.peekAll('video-category')
        });
    },
    afterModel: function (model) {
        this.setHeadTags(model.video);
    },
    actions: {
        edit(video_id){
            var video = this.store.peekRecord('video', video_id);
            var hash = video.get('youtubeId');
            if (hash) {
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
    setHeadTags: function (model) {
        var self = this;
        var headTags = [
            {
                type: 'meta',
                tagId: 'meta-og:site_name',
                attrs: {
                    property: 'og:site_name',
                    content: 'rumeo.net'
                }
            },
            {
                type: 'meta',
                tagId: 'meta-og:title',
                attrs: {
                    name: 'title',
                    property: 'og:title',
                    content: model.get('title')
                }
            },
            {
                type: 'link',
                tagId: 'link:image',
                attrs: {
                    rel: 'image_src',
                    href: self.getImage(model)
                }
            },
            {
                type: 'meta',
                tagId: 'meta-og:image',
                attrs: {
                    property: 'og:image',
                    content: self.getImage(model)
                }
            },
            {
                type: 'meta',
                tagId: 'meta-og:url',
                attrs: {
                    property: 'og:url',
                    content: 'http://rumeo.net/videos/' + model.get('id')
                }
            },
        ];
        this.set('headTags', function () {
            return headTags;
        });
    },
    getImage(video){
        var hash = /(embed\/)(.{11})/.exec(video.get('source'))[2];
        return `http://img.youtube.com/vi/${hash}/0.jpg`;
    }
});
