'use client';
import React from 'react';
import DateFilter from "@/app/ui/DateFilter";
import ReactPaginate from "react-paginate";
import ContactTable from "@/app/ui/ContactTable";
import useContacts from "@/app/hooks/useContacts";
import useConfig from "@/app/hooks/useConfig";
import useHandlers from "@/app/hooks/useHandlers";
import '@/app/ui/Pagination.css';

const Home = () => {
    const { hubspotAppUrl, contacts: {maxDate, minDate, years} } = useConfig();
    const {startDate, endDate, page, handlePageClick, handleDateFilter} = useHandlers();
    const [{contacts, pageCount, }, error] = useContacts({page, startDate, endDate});

    return (
        <div className="container mx-auto p-4">
            <div className="flex justify-between items-center mb-4 px-2">
                <p className="font-bold">{error ? 'Connect to Hubspot' : 'Data'}</p>
                <div className="flex items-center">
                    { !error &&  <DateFilter
                            maxDate={maxDate ?? ''}
                            minDate={minDate ?? ''}
                            years={years ?? []}
                            selectHandler={handleDateFilter}
                        />
                    }
                    <a href={hubspotAppUrl} className="ml-4">
                        <button className="standard-button">
                            Connect
                        </button>
                    </a>
                </div>
            </div>
            <ContactTable data={contacts}>
                {
                    contacts && contacts.length > 0 && <ReactPaginate
                        breakLabel="..."
                        nextLabel="Next &rarr;"
                        onPageChange={handlePageClick}
                        pageRangeDisplayed={5}
                        pageCount={pageCount}
                        previousLabel="&larr; Previous"
                        renderOnZeroPageCount={null}
                        containerClassName="flex items-center justify-between mt-4"
                        pageClassName="inline-block mx-2"
                        pageLinkClassName="px-3 py-2 flex items-center justify-center rounded-md border shadow-sm hover:bg-gray-200 transition-colors duration-300"
                        previousClassName="px-3 py-2 mr-auto flex items-center justify-center rounded-md border shadow-sm hover:bg-gray-200 transition-colors duration-300"
                        nextClassName="px-3 py-2 ml-auto flex items-center justify-center rounded-md border shadow-sm hover:bg-gray-200 transition-colors duration-300"
                        breakClassName="px-3 py-2 flex items-center justify-center rounded-md border shadow-sm hover:bg-gray-200 transition-colors duration-300"
                        activeClassName="bg-blue-500 rounded-md text-white"
                        disabledClassName="opacity-50 cursor-not-allowed"
                        previousLinkClassName="previous-button flex items-center justify-center"
                        nextLinkClassName="next-button flex items-center justify-center"
                    />
                }
            </ContactTable>
        </div>
    );
}


export default Home;