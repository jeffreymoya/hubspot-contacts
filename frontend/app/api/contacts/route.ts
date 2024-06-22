import {NextRequest, NextResponse} from 'next/server';
import query from "@/app/lib/query";
import {ContactsApiResponse} from "@/app/lib/types";
import {NextApiRequest} from "next";

export async function GET(req: NextRequest) {
    const p = req.nextUrl.searchParams;
    const cookieHeader = req.headers.get('cookie') ?? '';

    const response = await query<ContactsApiResponse>(`${process.env.CONTACTS_URL}?startDate=${p.get('startDate')}&endDate=${p.get('endDate')}&page=${p.get('page')}`, {
        headers: {
            cookie: cookieHeader,
        },
    });
    return NextResponse.json(response);
}
