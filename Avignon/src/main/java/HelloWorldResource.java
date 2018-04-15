import javax.ws.rs.GET;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;

@Path("/helloWorld")
public class HelloWorldResource {

	@GET
	//@Path()
	@Produces({"text/plain"})
	public String sayHello( ) {
		return "Hello World!";
	}
}
