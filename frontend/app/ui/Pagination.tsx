type PaginationProps = {
    totalPages: number;
    currentPage: number;
    setCurrentPage: (page: number) => void;
    handlePrevPage: () => void;
    handleNextPage: () => void;
};

/**
 * DateRangePicker is a component that allows the user to select a date range.
 * @param totalPages
 * @param currentPage
 * @param setCurrentPage
 * @param handlePrevPage
 * @param handleNextPage
 * @constructor
 */
const Pagination: React.FC<PaginationProps> = ({ totalPages, currentPage, setCurrentPage, handlePrevPage, handleNextPage }) => {
    return (
        <div className="px-4">
            <div className="flex justify-between mt-4 text-sm">
                <button
                    onClick={handlePrevPage}
                    className="standard-muted-button"
                    disabled={currentPage === 1}
                >
                    &larr; Previous
                </button>
                <div className="flex space-x-2">
                    {Array.from({length: totalPages}, (_, i) => (
                        <button
                            key={i}
                            onClick={() => setCurrentPage(i + 1)}
                            className={`px-4 py-2 border rounded ${currentPage === i + 1 ? 'bg-blue-500 text-white' : 'bg-white text-gray-700'}`}
                        >
                            {i + 1}
                        </button>
                    ))}
                </div>
                <button
                    onClick={handleNextPage}
                    className="standard-muted-button"
                    disabled={currentPage === totalPages}
                >
                    Next &rarr;
                </button>
            </div>
        </div>
    );
};

export default Pagination;