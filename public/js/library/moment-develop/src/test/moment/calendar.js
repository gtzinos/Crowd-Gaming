// These tests are for locale independent features
// locale dependent tests would be in locale test folder
import { module, test } from '../qunit';
import moment from '../../moment';

module('calendar');

test('passing a function', function (assert) {
    var a  = moment().hours(13).minutes(0).seconds(0);
    assert.equal(moment(a).calendar(null, {
        'sameDay': function () {
            return 'h:mmA';
        }
    }), '1:00PM', 'should equate');
});


