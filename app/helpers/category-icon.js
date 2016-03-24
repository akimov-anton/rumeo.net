export default Ember.Helper.helper(function (params) {
    var category_id = params[0];
    var icons = [
        'category_sprite_instructionals',
        '',
        'category_sprite_personal',
        'category_sprite_sports',
        'category_sprite_travel',
        '',
        'category_sprite_narrative',
        'category_sprite_music',
        'category_sprite_art'
    ];
    return icons[category_id - 1];
});