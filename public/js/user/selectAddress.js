var code_city = '';
var code_district = '';
var code_guild = '';

/**
 * template for option select
 * @param code
 * @param name
 * @returns {string}
 */
function tplOption(code, name) {
    var template = '<option value="{code}">{name}</option>';
    template = template.replace('{code}', code);
    template = template.replace('{name}', name);
    return template;
}

/**
 * get info from address.js city, district, guild
 * @param optionTpl
 * @param information
 * @returns {*}
 */
function getInfo(optionTpl, information) {
    var infos = Object.keys(information).map(function (item) {
        var name = information[item].name;
        var code = item;
        return {
            code: code,
            name: name
        };
    });
    infos.forEach(function (item) {
        optionTpl += tplOption(item.code, item.name);
    })
    return optionTpl;
}

/**
 * init page
 */
function init() {
    $('select[name="district"]').attr('disabled', true);
    $('select[name="guild"]').attr('disabled', true);

    var optionCities = '<option selected disabled hidden>Tỉnh/Thành phố</option>';
    var optionDistricts = '<option selected disabled hidden>Quận/Huyện</option>';
    var optionGuilds = '<option selected disabled hidden>Phường/Xã</option>';

    optionCities = getInfo(optionCities, info);

    $('select[name="city"]').html(optionCities);
    $('select[name="district"]').html(optionDistricts);
    $('select[name="guild"]').html(optionGuilds);
}

/**
 * on change event select city
 */
$(document).on('change', 'select[name="city"]', function (e) {
    $('select[name="guild"]').attr('disabled', true);
    code_district = '';
    code_guild = '';
    $('span[data-bind]').text('');
    var code = $(this).val();

    var optionDistricts = '<option selected disabled hidden>Quận/Huyện</option>';
    var optionGuild = '<option selected disabled hidden>Phường/Xã</option>';

    optionDistricts = getInfo(optionDistricts, info[code]['quan-huyen']);

    $('select[name="district"]').html(optionDistricts);
    $('select[name="guild"]').html(optionGuild);
    $('select[name="district"]').attr('disabled', false);

    code_city = code;
});

/**
 * on change event select district
 */
$(document).on('change', 'select[name="district"]', function (e) {
    $('span[data-bind]').text('');
    code_guild = '';
    var code = $(this).val();

    var optionGuild = '<option selected disabled hidden>Phường/Xã</option>';

    optionGuild = getInfo(optionGuild, info[code_city]['quan-huyen'][code]['xa-phuong']);

    $('select[name="guild"]').html(optionGuild);
    $('select[name="guild"]').attr('disabled', false);

    code_district = code;
});

/**
 * on change event select guild
 */
$(document).on('change', 'select[name="guild"]', function (e) {
    $('span[data-bind]').text('');
    var code = $(this).val();

    code_guild = code;
});

$(document).on('input', 'input[name="street"]', function () {
    $('span[data-bind]').text('');
});

init();
