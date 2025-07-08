/**
 * @file
 * Session Duplicate Detector
 *
 * Detects duplicate sessions in the schedule and adds roman numerals ("(I)",
 * "(II)", etc.) indicators to distinguish between different parts of the same
 * session.
 */
(function (Drupal) {
  'use strict';

  Drupal.behaviors.sessionDuplicateDetector = {
    attach: function (context, settings) {
      const sessionCards = document.querySelectorAll('[data-component-id="drupalcamp:session_schedule_card"]');

      if (sessionCards.length === 0) {
        return;
      }

      const sessionData = [];

      sessionCards.forEach((card, index) => {
        const titleElement = card.querySelector('.session-schedule-card__content a');
        if (titleElement) {
          const title = titleElement.textContent.trim();

          sessionData.push({
            index: index,
            title: title,
            originalTitle: title,
            titleContainer: titleElement,
            card: card,
          });
        }
      });

      const titleGroups = {};

      sessionData.forEach(session => {
        const normalizedTitle = session.title.toLowerCase().trim();
        const cleanTitle = normalizedTitle.replace(/\s*\([IV]+\)\s*$/, '');

        if (!titleGroups[cleanTitle]) {
          titleGroups[cleanTitle] = [];
        }
        titleGroups[cleanTitle].push(session);
      });

      Object.keys(titleGroups).forEach(cleanTitle => {
        const sessions = titleGroups[cleanTitle];

        if (sessions.length > 1) {
          sessions.sort((a, b) => a.index - b.index);
          sessions.forEach((session, groupIndex) => {
            const indicator = '(' + numberToRoman(groupIndex + 1) + ')';
            session.titleContainer.textContent = session.originalTitle + ' ' + indicator;
          });
        }
      });

      /**
       * Converts a number to Roman numerals.
       *
       * @param {number} num - The number to convert
       * @return {string} The Roman numeral representation
       */
      function numberToRoman(num) {
        const romanNumerals = [
          { value: 50, numeral: 'L' },
          { value: 40, numeral: 'XL' },
          { value: 10, numeral: 'X' },
          { value: 9, numeral: 'IX' },
          { value: 5, numeral: 'V' },
          { value: 4, numeral: 'IV' },
          { value: 1, numeral: 'I' },
        ];

        let result = '';
        let remaining = num;

        for (const { value, numeral } of romanNumerals) {
          while (remaining >= value) {
            result += numeral;
            remaining -= value;
          }
        }

        return result;
      }
    },
  };
})(Drupal);
