(function () {
  // Türkçe dil desteğini etkinleştir
  flatpickr.localize(flatpickr.l10ns.tr);

  // Global ayarları tanımla
  flatpickr.setDefaults({
    dateFormat: "d.m.Y", // Tarih formatı (gün.ay.yıl)
    altFormat: "j F, Y", // Alternatif tarih formatı (örneğin: 12 Ekim, 2023)
    altInput: true, // Alternatif giriş alanı kullan
    locale: "tr", // Türkçe dil ayarı
  });

  // 1. Default Date
  flatpickr("#datetime-local", {});

  // 2. Human Friendly
  flatpickr("#human-friendly", {});

  // 3. Min-Max Value
  flatpickr("#min-max", {
    maxDate: "15.12.2017",
  });

  // 4. Disabled Date
  flatpickr("#disabled-date", {
    disable: ["2025-01-30", "2025-02-21", "2025-03-08", new Date(2025, 4, 9)],
  });

  // 5. Multiple Date
  flatpickr("#multiple-date", {
    mode: "multiple",
  });

  // 6. Customizing the Conjunction
  flatpickr("#customize-date", {
    mode: "multiple",
    conjunction: " :: ",
  });

  // 7. Range Date
  flatpickr("#range-date", {
    mode: "range",
  });

  // 8. Disabled Range
  flatpickr("#preloading-date", {
    mode: "multiple",
    defaultDate: ["2016-10-20", "2016-11-04"],
  });

  // Time-picker

  // 9. Time Picker
  flatpickr("#time-picker", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
  });

  // 10. 24-hour Time Picker
  flatpickr("#twenty-four-hour", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true,
  });

  // 11. Time Picker W/Limits
  flatpickr("#limit-time", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    minTime: "16:00",
    maxTime: "22:30",
  });

  // 12. Preloading Time
  flatpickr("#preloading-time", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    defaultDate: "13:45",
  });

  // 13. DateTimePicker with Limited Time Range [min-time]
  flatpickr("#limit-time-range", {
    enableTime: true,
    minTime: "09:00",
  });

  // 14. DateTimePicker with Limited Time Range [min/max-time]
  flatpickr("#limit-min-max-range", {
    enableTime: true,
    minTime: "16:00",
    maxTime: "22:00",
  });

  // 15. Date With Time
  flatpickr("#datetime-local1", {
    enableTime: true,
    dateFormat: "Y-m-d H:i",
  });

  // 16. Inline Calendar
  flatpickr("#inline-calender", {
    inline: true,
  });
})();