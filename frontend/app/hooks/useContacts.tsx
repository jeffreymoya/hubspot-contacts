'use client';
import {useEffect, useState} from 'react';
import {ContactsApiResponse, DateFilterProp, ServerError} from "@/app/lib/types";
import query from "@/app/lib/query";

const initialData = {contacts: [], pageCount: 0, totalCount: 0} as ContactsApiResponse;

const useContacts = ({startDate = '', endDate = '', page = 1}: DateFilterProp & {page: number}): [ContactsApiResponse, ServerError | null] => {
    const [data, setData] = useState<ContactsApiResponse>(initialData);
    const [error, setError] = useState<ServerError | null>(null);

    useEffect(() => {
        (async () => {

            const response = await query<ContactsApiResponse>(`/api/contacts?startDate=${startDate}&endDate=${endDate}&page=${page}`);
            if(response) {
                setData(response);
            } else {
                setError({error: 'Error fetching data'});
            }
        })();
    }, [startDate, endDate, page]);

    return [data, error];
};

export default useContacts;