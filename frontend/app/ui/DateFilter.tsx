// @ts-nocheck
'use client';
import React, { useEffect, useRef } from 'react';
import $ from 'jquery';
import 'daterangepicker';
import 'daterangepicker/daterangepicker.css';
import '@/app/ui/custom-daterangepicker.css'
import moment from 'moment';
import {ContactStat} from "@/app/lib/types";

type ContactStatWithHandler = ContactStat & {
    selectHandler: (start: moment.Moment, end: moment.Moment, label: string) => void;
};

const DateRangePicker = ({minDate, maxDate, years, selectHandler}: ContactStatWithHandler) => {
    const datePickerRef = useRef(null);

    useEffect(() => {
        const ranges = years.reduce((acc: {[key: string]: moment.Moment[]}, year: string) => {
            acc[year] = [
                moment(`${year}-${moment().format('MM')}-01`),
                moment(`${year}-${parseInt(moment().format('MM')) + 1}-01`).subtract(1, 'days')
            ];
            return acc;
        }, {});

        $(datePickerRef.current).daterangepicker({
            opens: 'left',
            autoUpdateInput: false,
            alwaysShowCalendars: true,
            minDate: moment(minDate, 'YYYY-MM-DD HH:mm:ss'),
            maxDate: moment(maxDate, 'YYYY-MM-DD HH:mm:ss'),
            applyButtonClasses: 'standard-button p-10',
            cancelButtonClasses: 'standard-muted-button p-10',
            ranges,
        }, selectHandler);

        $(datePickerRef.current).on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'))
        });

        return () => {
            $(datePickerRef.current).data('daterangepicker')?.remove();
        };
    }, [years]);

    return (
        <input
            type="text"
            placeholder="Customer Date"
            ref={datePickerRef}
            className="date-filter form-control standard-muted-button"
        />
    );
};

export default DateRangePicker;
