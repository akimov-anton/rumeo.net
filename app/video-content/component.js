import Ember from 'ember';

export default Ember.Component.extend({
    //init(){
    //    this._super(...arguments);
    //    console.log('INIT');
    //},
    didReceiveAttrs(){
        this._super(...arguments);
        $('#vk_comments').html('');

        if (this.get('video').get('isFulfilled')) {
            this.get('video').then(video => {
                this.renderComments(video.get('id'));
            });
        }
        else{
            this.renderComments(this.get('video').get('id'));
        }
    },
    didRender(){
        this.renderSocialButtons();
    },
    renderComments(page_id){
        VK.Widgets.Comments("vk_comments", {
            limit: 10,
            width: "665",
            attach: "*",
        }, page_id);
    },
    renderSocialButtons(){
        console.log($('#ya-share2').text());
        var self = this;
        var share = Ya.share2('ya-share2', {
            content: {
                url: 'https://rumeo.net/' + self.get('video').get('id'),
                title: self.get('video').get('title'),
                description: self.get('video').get('title'),
                image: self.getImage(self.get('video'))
            },
            theme: {
                services: 'vkontakte,facebook,odnoklassniki,gplus',
                counter: true,
                lang: 'ru',
                //limit: 3,
                size: 'm',
                bare: false
            },
            hooks: {
                //onready: function () {
                //    alert('блок инициализирован');
                //},
            }
        });
        console.log(share);
    },
    getImage(video){
        var hash = /(embed\/)(.{11})/.exec(video.get('source'))[2];
        return `http://img.youtube.com/vi/${hash}/0.jpg`;
    }
});