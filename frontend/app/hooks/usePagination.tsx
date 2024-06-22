'use client';
import { useState, useMemo, useCallback } from 'react';
import {PaginationProps, PaginationReturnType} from "@/app/lib/types";

const usePagination = ({ initialPage, itemsPerPage, items }: PaginationProps): PaginationReturnType => {
  const [currentPage, setCurrentPage] = useState(initialPage);
  const totalPages = useMemo(() => Math.ceil(items.length / itemsPerPage), [items, itemsPerPage]);

  const handlePrevPage = useCallback(() => {
    if (currentPage > 1) setCurrentPage(currentPage - 1);
  }, [currentPage]);

  const handleNextPage = useCallback(() => {
    if (currentPage < totalPages) setCurrentPage(currentPage + 1);
  }, [currentPage, totalPages]);

  const handleCurrentPage = useCallback((page: number) => {
    if (page >= 1 && page <= totalPages) {
      setCurrentPage(page);
    }
  }, [totalPages]);

  const indexOfLastItem = currentPage * itemsPerPage;
  const indexOfFirstItem = indexOfLastItem - itemsPerPage;
  const currentItems = useMemo(() => items.slice(indexOfFirstItem, indexOfLastItem), [items, currentPage, itemsPerPage]);

  return {
    currentPage,
    handlePrevPage,
    handleNextPage,
    handleCurrentPage,
    currentItems,
    totalPages,
  };
};

export default usePagination;