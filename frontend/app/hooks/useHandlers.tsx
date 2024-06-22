'use client';
import { useState, useMemo, useCallback } from 'react';
import {DateFilterCallbackProp, DateFilterProp, PaginationProps, PaginationReturnType} from "@/app/lib/types";

const useHandlers = () => {
  const [dates, setDates] = useState<DateFilterProp>();
  const [page, setPage] = useState(1);
  const handlePageClick = useCallback(({selected}: { selected: number; }) => setPage(selected+1), [setPage]);
  const handleDateFilter = useCallback((start: DateFilterCallbackProp, end: DateFilterCallbackProp, label: any) => {
    setDates({startDate: start.format('YYYY-MM-DD'), endDate: end.format('YYYY-MM-DD')});
  }, [setDates]);

  return {
    ...dates,
    page,
    handlePageClick,
    handleDateFilter,
  };
};

export default useHandlers;