
                        jQuery(document).ready(function($) {

                            var monthNames = ["Январь", "Февраль", "Март", "АПрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];

                            var dayNames = ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"];

                          /*  var events = [
                                {
                                    date: "1/9/2015",
                                    title: 'SPORT & WELLNESS',
                                    link: '324324',
                                    color: '234234',
                                    content: '<img src="http://gettingcontacts.com/upload/jornadas/sport-wellness_portada.png" ><br>06-11-2013 - 09:00 <br> Tecnocampus Mataró Auditori',
                                    class: '',
                                }
                            ];*/

                            var events = [];

                            $('#calendari_lateral1').bic_calendar({
                                //list of events in array
                                events: events,
                                //enable select
                                enableSelect: false,
                                //enable multi-select
                                multiSelect: false,
                                //set day names
                                dayNames: dayNames,
                                //set month names
                                monthNames: monthNames,
                                //show dayNames
                                showDays: true,
                                //set ajax call
                                reqAjax: {
                                    type: 'get',
                                    url: '/?AJAX_REQUEST=Y&method=calendarEvents'
                                }
                                //set popover options
                                //popoverOptions: {}
                                //set tooltip options
                                //tooltipOptions: {}
                            });
                        });
                    